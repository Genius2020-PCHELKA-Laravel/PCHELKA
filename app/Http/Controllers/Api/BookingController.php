<?php

namespace App\Http\Controllers\Api;

use App\Enums\BookingStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\PaymentWaysEnum;
use App\Enums\ServicesEnum;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingAnswers;
use App\Models\QuestionDetails;
use App\Models\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Validator;
use function Safe\eio_lstat;

class BookingController extends Controller
{
    use ApiResponseTrait;

//dd(Str::random(6));
    public function createRefCode()
    {
        global $data;
        do {
            $data = Str::random(6);
            $refCode = Booking::where('refCode', $data)->first();
        } while ($refCode != null);
        return $data;
    }

    public function bookService(Request $request)
    {

//        try {
//            #region UserInputValidate
//            $validator = Validator::make($request->all(), [
//                'serviceType' => ['required', new EnumKey(ServicesEnum::class)],
//                'duoDate' => ['required', 'date_format:Y-m-d'],
//                'duoTime' => ['required', 'date_format:H:i:s'],
//                'subTotal' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
//                'discount' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
//                'totalAmount' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
//                'locationId' => ['required', 'integer'],
//                'providerId' => ['required', 'integer'],
//                'scheduleId' => ['required', 'integer'],
//                'paymentWays' => ['required', new EnumKey(PaymentWaysEnum::class)],
//                'answers' => [
//                    'questionId' => ['required', 'integer'],
//                ],
//            ]);
//            if ($validator->fails()) {
//                return $this->apiResponse(null, $validator->errors(), 520);
//            }
        //     #endregion
        if (Auth::check()) {
            $userId = Auth::user()->id;
            #region AddBooking
            $bookingUserId = $userId;
            $bookingServiceId = ServicesEnum::coerce($request->serviceType);
            $date = strtotime($request->duoDate);
            $booking = new Booking();
            $booking->duoDate = $request->duoDate;
            $booking->duoTime = $request->duoTime;
            $booking->subTotal = $request->subTotal;
            $booking->discount = $request->discount;
            $booking->totalAmount = $request->totalAmount;
            $booking->paidStatus = PaymentStatusEnum::NotPaid;
            $booking->paymentWays = PaymentWaysEnum::coerce($request->paymentWays);
            $booking->status = BookingStatusEnum::Created;
            $booking->serviceType = ServicesEnum::coerce($request->serviceType);
            $booking->userId = $bookingUserId;
            $booking->serviceId = $bookingServiceId;
            $booking->locationId = $request->locationId;
            $booking->providerId = $request->providerId;
            $booking->scheduleId = $request->scheduleId;
            $booking->parentId = null;
            $booking->refCode = $this->createRefCode();
            $booking->save();
            $lastId = intval($booking->id);
            switch ($request->frequency) {
                case "One-time":
                {
                    break;
                }
                case "Weekly":
                {
                    for ($i = 0; $i <= 2; $i++) {
                        $date = strtotime("+7 day", $date);
                        $endDate = date('Y/m/d', $date);
                        $bookingChild = new Booking();
                        $bookingChild->duoDate = $endDate;
                        $bookingChild->duoTime = $request->duoTime;
                        $bookingChild->subTotal = null;
                        $bookingChild->discount = null;
                        $bookingChild->totalAmount = null;
                        $bookingChild->paidStatus = PaymentStatusEnum::NotPaid;
                        $bookingChild->status = BookingStatusEnum::Created;
                        $bookingChild->serviceType = ServicesEnum::coerce($request->serviceType);
                        $bookingChild->userId = $bookingUserId;
                        $bookingChild->serviceId = $bookingServiceId;
                        $bookingChild->providerId = $request->providerId;
                        $bookingChild->parentId = $lastId;
                        $bookingChild->refCode = $this->createRefCode();
                        $bookingChild->save();
                    }
                    break;
                }
                case "Bi-weekly":
                {
                    $date = strtotime("+15 day", $date);
                    $endDate = date('Y/m/d', $date);
                    $bookingChild = new Booking();
                    $bookingChild->duoDate = $endDate;
                    $bookingChild->duoTime = $request->duoTime;
                    $bookingChild->subTotal = null;
                    $bookingChild->discount = null;
                    $bookingChild->totalAmount = null;
                    $bookingChild->paidStatus = PaymentStatusEnum::NotPaid;
                    $bookingChild->status = BookingStatusEnum::Created;
                    $bookingChild->serviceType = ServicesEnum::coerce($request->serviceType);
                    $bookingChild->userId = $bookingUserId;
                    $bookingChild->serviceId = $bookingServiceId;
                    $bookingChild->parentId = $lastId;
                    $bookingChild->providerId = $request->providerId;
                    $bookingChild->refCode = $this->createRefCode();
                    $bookingChild->save();
                    break;
                }
                default:
                    return $this->apiResponse("Please select correct frequency value !");
            }
            #endregion
            #region AddBookingAnswers
            $answers = $request->answers;
            foreach ($answers as $answer) {
                $bookingAnswers = new BookingAnswers();
                $bookingAnswers->bookingId = $lastId;
                $bookingAnswers->questionId = $answer['questionId'];
                if ($answer['answerId'] != null) {
                    $bookingAnswers->answerId = $answer['answerId'];
                    $bookingAnswers->answerValue = null;
                } else {
                    $bookingAnswers->answerValue = $answer['answerValue'];
                    $bookingAnswers->answerId = null;
                }
                $bookingAnswers->save();
            }
            #endregion
            return $this->createdResponse('Booking created successfully');
        } else {
            return $this->unAuthoriseResponse();
        }
//        } catch (\Exception $exception) {
//            return $this->generalError();
//        }
    }

    public function updateBookingEnum(Request $request)
    {
        try {
            #region UserInputValidate
            $validator = Validator::make($request->all(), [
                'id' => ['required', 'integer', 'min:1'],
                'operator' => ['required', 'integer', 'min:1', 'max:4'],
            ]);
            if ($validator->fails()) {
                return $this->apiResponse(null, $validator->errors(), 520);
            }
            #endregion
            $booking = Booking::find($request->id);
            if (!$booking['id']) {
                return $this->notFoundMassage();
            }

            $operator = intval($request->operator);
            switch ($operator) {

                case 1: // Payment status
                    //  if (PaymentStatusEnum:: ( $request->type)) {
                    $booking['paidStatus'] = PaymentStatusEnum::coerce($request->type);
                    $booking->save();
                    // }
                    //  return $this->apiResponse(null, 'Error ! ', 190);

                    break;
                case 2: // Payment ways
                    $booking['paymentWays'] = PaymentWaysEnum::coerce($request->type);
                    $booking->save();
                    break;
                case 3: // Booking status
                    $booking['status'] = BookingStatusEnum::coerce($request->type);
                    $booking->save();
                    break;
                case 4: // Service Type
                    $booking['serviceType'] = ServicesEnum::coerce($request->type);
                    $booking->save();
                    break;
            }
            return $this->apiResponse("Update successfully", null, 200);
        } catch
        (\Exception $exception) {
            return $this->generalError();
        }
    }

    public function getQuestionsPrice(Request $request)
    {
        //validate
        $answers = $request->answers;
        $price = 0;

        #region GetPriceAndSum
        foreach ($answers as $answer) {
            $questionDetails = QuestionDetails::where('id', '=', $answer['questionId'])->first();
            if ($questionDetails) {
                $price = $price + $questionDetails->price;
            } else {
                return $this->notFoundMassage("The question id : " . $answer['questionId'] . " /");
            }
        }
        #endregion

        return $this->apiResponse($price, null, 200);
    }

    public function getPastBooking(Request $request)
    {
        $response = array();
        if (Auth::user()) {

            $user = Auth::user()->id;
            $data = Booking::where('userId', $user)->where(function ($q) {
                $q->where('status', '=', BookingStatusEnum::Canceled())
                    ->orWhere('status', '=', BookingStatusEnum::Completed());
            })
                ->orderBy('created_at', 'asc')
                ->get();
            foreach ($data as $newdata) {
                $row = [
                    'id' => $newdata['id'],
                    'duoDate' => $newdata['duoDate'],
                    'duoTime' => $newdata['duoTime'],
                    'serviceType' => ServicesEnum::getKey($newdata['serviceType']),
                    'refCode' => $newdata['refCode'],
                    'status' => BookingStatusEnum::getKey($newdata['status']),
                    'providerData' => ServiceProvider::where('id', $newdata['providerId'])->select('id', 'name', 'imageUrl')->first()
                ];
                array_push($response, $row);

            }
            return $this->apiResponse($response);
        }
        return $this->unAuthoriseResponse();
    }

    public function getUpComingBooking(Request $request)
    {
        $response = array();
        if (Auth::user()) {

            $user = Auth::user()->id;
            $data = Booking::where('userId', $user)->where(function ($q) {
                $q->where('status', '=', BookingStatusEnum::Created());
            })
                ->orderBy('created_at', 'asc')
                ->get();
            foreach ($data as $newdata) {
                $row = [
                    'id' => $newdata['id'],
                    'duoDate' => $newdata['duoDate'],
                    'duoTime' => $newdata['duoTime'],
                    'serviceType' => ServicesEnum::getKey($newdata['serviceType']),
                    'refCode' => $newdata['refCode'],
                    'status' => BookingStatusEnum::getKey($newdata['status']),
                    'providerData' => ServiceProvider::where('id', $newdata['providerId'])->select('id', 'name', 'imageUrl')->first()
                ];
                array_push($response, $row);

            }
            return $this->apiResponse($response);
        }
        return $this->unAuthoriseResponse();
    }
}
