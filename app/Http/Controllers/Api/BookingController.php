<?php

namespace App\Http\Controllers\Api;

use App\Enums\BookingStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\PaymentWaysEnum;
use App\Enums\ServicesEnum;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingAnswers;
use App\Models\Question;
use App\Models\QuestionDetails;
use App\Models\Schedule;
use App\Models\ServiceProvider;
use App\Models\UserLocation;
use App\User;
use BenSampo\Enum\Enum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use SebastianBergmann\Comparator\Book;
use Validator;
use function Safe\eio_lstat;

class BookingController extends Controller
{
    use ApiResponseTrait;
    use BookingHelperTrait;

    public function convertString($enum)
    {
        $temp = preg_replace('%([a-z])([A-Z])%', '\1 \2', $enum);
        return $temp;
    }

    public function createRefCode()
    {
        global $data;
        do {
            $data = strtoupper(Str::random(6));
            $refCode = Booking::where('refCode', $data)->first();
        } while ($refCode != null);
        return $data;
    }

    public function deActiveSchdule($duoDate, $providerId, $answare, $duoTime)
    {
//        $duoDate = $request->$duoDate;
//        $providerId = $request->$providerId;
//        $providerId = $request->$providerId;
//        $answare = $request->$answare;
//        $duoTime = $request->$duoTime;
        global $to;
        switch ($answare) {
            case 4 :
            case 17 :
            case 29 :
            case 41 :
            {
                $to = 60 * 60 * 2;
                break;
            }

            case 5 :
            case 18 :
            case 30 :
            case 42 :
            {
                $to = 60 * 60 * 3;
                break;
            }

            case 6 :
            case 19 :
            case 31 :
            case 43 :
            {
                $to = 60 * 60 * 4;
                break;
            }

            case 7 :
            case 20 :
            case 32 :
            case 44 :
            {
                $to = 60 * 60 * 5;
                break;
            }

            case 8 :
            case 21 :
            case 33 :
            case 45 :
            {
                $to = 60 * 60 * 6;
                break;
            }

            case 9 :
            case 22 :
            case 34 :
            case 46 :
            {
                $to = 60 * 60 * 7;
                break;
            }
            default:
            {
                return $this->apiResponse('Please select available time value', null, 404);
            }
        }
        $timestamp = strtotime($duoTime) + intval($to);
        $endTime = date('H:i', $timestamp);

        $data = Schedule::where('availableDate', $duoDate)
            ->where('serviceProviderId', $providerId)
            ->whereBetween('timeStart', [$duoTime, $endTime])
            ->get();
        foreach ($data as $singleData) {
            $schedule = Schedule::where('id', $singleData['id'])->first();
            $schedule['isActive'] = 0;
            $schedule->save();
        }
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
        global $answerHourValue;
        if (Auth::check()) {
            $answerss = $request->answers;
            foreach ($answerss as $answer) {
                switch (intval($answer['questionId'])) {
                    case 2:
                    case 6:
                    case 9:
                    case 12:
                        $answerHourValue = $answer['answerId'];
                }

            }
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
            $booking->status = BookingStatusEnum::Confirmed;
            $booking->serviceType = ServicesEnum::coerce($request->serviceType);
            $booking->userId = $bookingUserId;
            $booking->serviceId = $bookingServiceId;
            $booking->locationId = $request->locationId;
            $booking->providerId = $request->providerId;
            $booking->parentId = null;
            $booking->refCode = $this->createRefCode();
            $booking->save();
            $lastId = intval($booking->id);


            switch ($request->frequency) {
                case "One-time":
                {
                    $this->deActiveSchdule($request->duoDate, $request->providerId, $answerHourValue, $request->duoTime);
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
                        $bookingChild->status = BookingStatusEnum::Confirmed;
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
                    $bookingChild->status = BookingStatusEnum::Confirmed;
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
            $data = Booking::where('userId', $user)->where('status', '=', BookingStatusEnum::Completed)
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
            $data = Booking::where('userId', $user)->where('status', '=', BookingStatusEnum::Confirmed())
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

    public function getHCBookingById(Request $request)
    {
        if (Auth::user()) {
            $response = array();
            $response = $this->getBookingDetailes($request->id);

            $answers = null;
            if ($response['parentId'] != null) {
                $answers = BookingAnswers::where('bookingId', $book->parentId)->select(['answerValue', 'answerId', 'questionId'])->get();
            } else {
                $answers = BookingAnswers::where('bookingId', $request->id)->select(['answerValue', 'answerId', 'questionId'])->get();
            }
            foreach ($answers as $answer) {
                if ($answer['questionId'] == 1) {
                    $response['frequency'] = $this->frequencyConvert($answer['answerId']);
                } elseif ($answer['questionId'] == 2) {
                    $response['hoursNeeded'] = $this->getAnswer($answer['answerId']);
                } elseif ($answer['questionId'] == 3) {
                    $response['cleanerCount'] = $this->getAnswer($answer['answerId']);
                } elseif ($answer['questionId'] == 4) {
                    $response['requireMaterial'] = $this->materialsConvert($answer['answerId']);
                }
            }
            return $this->apiResponse($response);
        } else {
            return $this->unAuthoriseResponse();
        }
    }

    public function getBookingById(Request $request)
    {
        if (Auth::user()) {
            $response = array();
            $response = $this->getBookingDetailes($request->id);
            $answers = null;
            if ($response['parentId'] != null) {
                $answers = BookingAnswers::where('bookingId', $book->parentId)->select(['answerValue', 'answerId', 'questionId'])->get();
            } else {
                $answers = BookingAnswers::where('bookingId', $request->id)->select(['answerValue', 'answerId', 'questionId'])->get();
            }
            $answerRes = array();
            foreach ($answers as $answer) {
                $row = [
                    'question' => $answer['questionId'],
                    'answer' => $answer['answerId'] ? $answer['answerId'] : $answer['answerValue']
                ];
                array_push($answerRes, $row);
            }
            $response['answers'] = $answerRes;
            return $this->apiResponse($response);
        } else {
            return $this->unAuthoriseResponse();
        }

    }

    public function t()
    {
//        $time = array(
//            strtotime('08:00'),
//            strtotime('08:30'),
//            strtotime('09:00'),
//            strtotime('09:30'),
//            strtotime('10:00'),
//            strtotime('10:30'),
//            strtotime('11:00'),
//            strtotime('11:30'), //isActiveFalse
//            strtotime('12:00'),
//            strtotime('12:30'),
//        );
//
//        $tt = $time[0] + (60 * 60) * 2;
//        if (in_array($tt, $time)) {
//            dd('true');
//        } else {
//            dd('notfound');
//        }

        $times = Schedule::where('serviceProviderId', 1)->where('availableDate', '2020-06-06')->select(['id', 'timeStart', 'isActive'])->get();

        foreach ($times as $time) {
            if ($time['isActive'] == 1) {
                $tt = date('H:i', strtotime($time['timeStart']) + (60 * 60) * 2);
                $timeCond = Schedule::where('serviceProviderId', 1)->where('availableDate', '2020-06-06')->
                where('timeStart', $tt)->select(['timeStart', 'isActive'])->first();
                if ($timeCond && $timeCond['isActive'] == false) {
                    $row = Schedule::where('id',$time['id'])->first();
                    $row['isActive']=0;
                    $row->save();
                }

            }
        }
        #region d

//        for ($i = 0; $i <= count($time) - 1; $i = $i + 1) {
//            $startDate = new  \DateTime(date('H:i', $time[$i]));
//            if ($i + 1 == count($time)) {
//                break;
//            } else {
//                $end = $startDate->diff(new \DateTime(date('H:i', $time[$i + 1])));
//                echo $end->h . ' hours<br>';
//                echo $end->i . ' minutes<br>';
//                echo ' ---------------------------<br>';
//            }
//        }
        #endregion

    }
}
