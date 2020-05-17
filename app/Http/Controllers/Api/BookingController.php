<?php

namespace App\Http\Controllers\Api;

use App\Enums\PaymentWaysEnum;
use App\Models\Booking;
use App\Http\Controllers\Controller;
use App\Models\BookingAnswers;
use App\Models\QuestionDetails;
use App\Models\Service;
use BenSampo\Enum\Rules\EnumKey;
use Illuminate\Http\Request;
use App\Enums\BookingStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\ServicesEnum;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    use ApiResponseTrait;

    public function bookService(Request $request)
    {
        try {
            #region UserInputValidate
            $validator = Validator::make($request->all(), [
                'serviceType' => ['required', new EnumKey(ServicesEnum::class)],
                'dueDate' => ['required', 'date_format:Y-m-d H:i:s'],
                'frequency' => ['integer', 'min:1', 'max:3'],
                'answers' => [
                    'questionId' => ['required', 'integer'],
                ],
            ]);
            if ($validator->fails()) {
                return $this->apiResponse(null, $validator->errors(), 520);
            }
            #endregion
            if (Auth::check()) {
                $answers = $request->answers;
                $price = 0;

                #region GetPriceAndSum
                foreach ($answers as $answer) {
//                    if ($answer) {
                    $questionDetails = QuestionDetails::where('id', '=', $answer['questionId'])->first();
                    $price = $price + $questionDetails->price;
//                    } else {
//                        return $this->notFoundMassage('Question');
//                    }
                }

                #endregion

                #region AddBookingToTable
                $bookingUserId = Auth::user()->id;
                $bookingServiceId = Service::where('type', ServicesEnum::coerce($request->serviceType))->first()->id;;
                $bookingDiscount = 0;
                $bookingTotalAmount = $price - ($price * $bookingDiscount / 100);
                $booking = new Booking();
                $booking->duoDate = $request->dueDate;
                $booking->price = $price;
                $booking->discount = $bookingDiscount;
                $booking->totalAmount = $bookingTotalAmount;
                $booking->paidStatus = PaymentStatusEnum::NotPaid;
                $booking->status = BookingStatusEnum::Created;
                $booking->serviceType = ServicesEnum::coerce($request->serviceType);
                $booking->userId = $bookingUserId;
                $booking->serviceId = $bookingServiceId;
                $booking->parentId = null;
                $booking->save();
                $lastId = intval($booking->id);
                #endregion
                $serviceFreq = Service::where('type', ServicesEnum::coerce($request->serviceType))->first()->hasFrequency;
                if ($serviceFreq == 1) {
                    $frequency = intval($request->frequency);
                    $duoDate = $booking->duoDate;
                    for ($i = 0; $i <= $frequency - 1; $i++) {
                        $bookingChild = new Booking();
                        $bookingChild->duoDate = $duoDate;
                        $bookingChild->price = $price;
                        $bookingChild->discount = $bookingDiscount;
                        $bookingChild->totalAmount = $bookingTotalAmount;
                        $bookingChild->paidStatus = PaymentStatusEnum::NotPaid;
                        $bookingChild->status = BookingStatusEnum::Created;
                        $bookingChild->serviceType = ServicesEnum::coerce($request->serviceType);
                        $bookingChild->userId = $bookingUserId;
                        $bookingChild->serviceId = $bookingServiceId;
                        $bookingChild->parentId = $lastId;
                        $bookingChild->save();
                    }
                }
                #region AddBookingAnswers
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
        } catch (\Exception $exception) {
            return $this->generalError();
        }
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
            $price = $price + $questionDetails->price;
        }
        #endregion

        return $this->apiResponse($price, null, 200);
    }
}
