<?php

namespace App\Http\Controllers\Api;

use App\Enums\BookingStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\PaymentWaysEnum;
use App\Enums\ServicesEnum;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingAnswers;
use App\Models\Evaluation;
use App\Models\QuestionDetails;
use App\Models\Schedule;
use App\Models\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PHPUnit\Exception;
use Validator;
use function Safe\eio_lstat;

class BookingController extends Controller
{
    use ApiResponseTrait;
    use BookingHelperTrait;


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
            $providerId = $request->providerId == null ? $providerId = $this->autoAssignId($request->duoDate, $request->serviceType) : $request->providerId;
            if ($providerId == null) {
                return $this->apiResponse('The time is not available please select another time');
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
            $booking->providerId = $providerId;
            $booking->parentId = null;
            $booking->refCode = $this->createRefCode();
            $booking->materialPrice = $request->materialPrice;
            $booking->save();
            $lastId = intval($booking->id);
//            $this->deActiveSchdule($request->duoDate, $providerId, $answerHourValue, $request->duoTime);
//            $this->removeGap($providerId, $request->duoDate);
            switch ($request->frequency) {
                case "One-time":
                {
                    $this->deActiveSchdule($request->duoDate, $providerId, $answerHourValue, $request->duoTime);
                    $this->removeGap($providerId, $request->duoDate);
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
                        $bookingChild->providerId = $providerId;
                        $bookingChild->parentId = $lastId;
                        $bookingChild->refCode = $this->createRefCode();
                        $bookingChild->save();

                        $schdule = Schedule::where('serviceProviderId', $providerId)->where('availableDate', $endDate)->get();
                        if (count($schdule) < 1) {
                            $begin = new  \DateTime($request->duoTime);
                            $endTime = $this->switchHourAnswer($request->duoTime, $answerHourValue);
                            $endFormat = date('H:i', strtotime($endTime . '+30 minutes'));
                            $end = new \DateTime($endFormat);
                            $interval = \DateInterval:: createFromDateString('30 min');
                            $times = new \DatePeriod($begin, $interval, $end);

                            foreach ($times as $time) {
                                $newSchdule = new Schedule();
                                $newSchdule->availableDate = $endDate;
                                $newSchdule->timeStart = $time->format('H:i');
                                $newSchdule->timeEnd = $time->add($interval)->format('H:i');
                                $newSchdule->serviceProviderId = $providerId;
                                $newSchdule->isActive = false;
                                $newSchdule->save();
                            }
                        } else {
                            $this->deActiveSchdule($endDate, $providerId, $answerHourValue, $request->duoTime);
                            $this->removeGap($providerId, $request->duoDate);
                        }
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
                    $bookingChild->providerId = $providerId;
                    $bookingChild->refCode = $this->createRefCode();
                    $bookingChild->save();

                    $schdule = Schedule::where('serviceProviderId', $providerId)->where('availableDate', $endDate)->get();
                    if (count($schdule) < 1) {
                        $begin = new  \DateTime($request->duoTime);
                        $endTime = $this->switchHourAnswer($request->duoTime, $answerHourValue);
                        $endFormat = date('H:i', strtotime($endTime . '+30 minutes'));
                        $end = new \DateTime($endFormat);
                        $interval = \DateInterval:: createFromDateString('30 min');
                        $times = new \DatePeriod($begin, $interval, $end);

                        foreach ($times as $time) {
                            $newSchdule = new Schedule();
                            $newSchdule->availableDate = $endDate;
                            $newSchdule->timeStart = $time->format('H:i');
                            $newSchdule->timeEnd = $time->add($interval)->format('H:i');
                            $newSchdule->serviceProviderId = $providerId;
                            $newSchdule->isActive = false;
                            $newSchdule->save();
                        }
                    } else {
                        $this->deActiveSchdule($endDate, $providerId, $answerHourValue, $request->duoTime);
                        $this->removeGap($providerId, $request->duoDate);
                    }
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

    public function getPastBooking()
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

    public function getUpComingBooking()
    {
        $response = array();
        if (Auth::user()) {

            $user = Auth::user()->id;

            $data = Booking::where('userId', $user)->where('status', '=', BookingStatusEnum::Confirmed())
                ->where('duoDate', '>', date('Y-m-d', strtotime("-1 days")))
                ->orderBy('created_at', 'asc')
                ->get();

            foreach ($data as $newdata) {
                $providerData = ServiceProvider::where('id', $newdata['providerId'])->select('id', 'name', 'imageUrl')->first();
                $providerData['evaluation'] = intval(Evaluation::where('serviceProviderId', $newdata['providerId'])->avg('starCount'));
                $lastServiceDate =
                    Booking::where('userId', $user)->where('providerId', $newdata->providerId)
                        ->where('status', BookingStatusEnum::Completed)
                        ->where('serviceType', ServicesEnum::coerce($newdata['serviceType']))
                        ->orderBy('duoDate', 'DESC')
                        ->select('duoDate')->first();
                $providerData['lastServiceDate'] = $lastServiceDate['duoDate'];
                $row = [
                    'id' => $newdata['id'],
                    'duoDate' => $newdata['duoDate'],
                    'duoTime' => $newdata['duoTime'],
                    'serviceType' => ServicesEnum::getKey($newdata['serviceType']),
                    'refCode' => $newdata['refCode'],
                    'status' => BookingStatusEnum::getKey($newdata['status']),
                    'providerData' => $providerData,

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

            if ($response['parentId'] != null) {
                $data = Booking::where('id', $response['parentId'])
                    ->select(['totalAmount', 'discount', 'subTotal', 'materialPrice','paymentWays'])->first();
                $response['totalAmount'] = $data['totalAmount'];
                $response['discount'] = $data['discount'];
                $response['subTotal'] = $data['subTotal'];
                $response['materialPrice'] = $data['materialPrice'];
                $response['paymentWays'] = $data['paymentWays'];

            }

            $answers = null;
            if ($response['parentId'] != null) {
                $answers = BookingAnswers::where('bookingId', $response['parentId'])->select(['answerValue', 'answerId', 'questionId'])->get();
            } else {
                $answers = BookingAnswers::where('bookingId', $request->id)->select(['answerValue', 'answerId', 'questionId'])->get();
            }
            foreach ($answers as $answer) {
                switch (ServicesEnum::getValue($response['serviceType'])) {

                    #region HomeCleaning
                    case ServicesEnum::HomeCleaning :
                    {
                        if ($answer['questionId'] == 1) {
                            $response['frequency'] = $this->frequencyConvert($answer['answerId']);
                        } elseif
                        ($answer['questionId'] == 2) {
                            $response['hoursNeeded'] = $this->getAnswer($answer['answerId']);
                        } elseif
                        ($answer['questionId'] == 3) {
                            $response['cleanerCount'] = $this->getAnswer($answer['answerId']);
                        } elseif
                        ($answer['questionId'] == 4) {
                            $response['requireMaterial'] = $this->materialsConvert($answer['answerId']);
                        }
                        break;
                    }
                    #endregion

                    #region BabysitterService
                    case ServicesEnum::BabysitterService :
                    {

                        if ($answer['questionId'] == 1) {
                            $response['frequency'] = $this->frequencyConvert($answer['answerId']);
                        } elseif
                        ($answer['questionId'] == 12) {
                            $response['hoursNeeded'] = $this->getAnswer($answer['answerId']);
                        } elseif
                        ($answer['questionId'] == 13) {
                            $response['cleanerCount'] = $this->getAnswer($answer['answerId']);
                        }
                        break;
                    }
                    #endregion

                    #region DisinfectionService
                    case ServicesEnum::DisinfectionService :
                    {

                        if ($answer['questionId'] == 1) {
                            $response['frequency'] = $this->frequencyConvert($answer['answerId']);
                        } elseif
                        ($answer['questionId'] == 6) {
                            $response['hoursNeeded'] = $this->getAnswer($answer['answerId']);
                        } elseif
                        ($answer['questionId'] == 7) {
                            $response['cleanerCount'] = $this->getAnswer($answer['answerId']);
                        } elseif
                        ($answer['questionId'] == 8) {
                            $response['requireMaterial'] = $this->materialsConvert($answer['answerId']);
                        }
                        break;
                    }
                    #endregion

                    #region DeepCleaning
                    case ServicesEnum::DeepCleaning :
                    {

                        if ($answer['questionId'] == 1) {
                            $response['frequency'] = $this->frequencyConvert($answer['answerId']);
                        } elseif
                        ($answer['questionId'] == 9) {
                            $response['hoursNeeded'] = $this->getAnswer($answer['answerId']);
                        } elseif
                        ($answer['questionId'] == 10) {
                            $response['cleanerCount'] = $this->getAnswer($answer['answerId']);
                        } elseif
                        ($answer['questionId'] == 11) {
                            $response['requireMaterial'] = $this->materialsConvert($answer['answerId']);
                        }
                        break;
                    }
                    #endregion
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

    public function rescheduleBook(Request $request)
    {
        try {
            if (Auth::user()) {
                $book = Booking::where('id', $request->id)->first();
                global $oldHourId;
                if ($book) {
                    if ($book->parentId != null) {
                        $oldHourId = BookingAnswers::where('bookingId', $book->parentId)->where('questionId', 2)
                            ->orWhere('questionId', 6)->orWhere('questionId', 9)->orWhere('questionId', 12)
                            ->select(['answerId'])->first();

                    } else {
                        $oldHourId = BookingAnswers::where('bookingId', $request->id)->where('questionId', 2)
                            ->orWhere('questionId', 6)->orWhere('questionId', 9)->orWhere('questionId', 12)
                            ->select(['answerId'])->first();

                    }

                    $oldProviderId = Booking::where('id', $request->id)->select(['providerId'])->first();

                    $oldDate = Booking::where('id', $request->id)->select(['duoDate'])->first();
                    $oldTime = Booking::where('id', $request->id)->select(['duoTime'])->first();
                    $serviceProvider = $request->providerId == null ? $this->autoAssignId($request->duoDate, $book->serviceType) : $request->providerId;
                    $book->duoDate = $request->duoDate;
                    $book->duoTime = $request->duoTime;
                    $book->providerId = $serviceProvider;
                    $book->save();

                    $this->deActiveSchdule($request->duoDate, $serviceProvider, $oldHourId['answerId'], $request->duoTime);
                    $this->activeSchdule($oldDate['duoDate'], $oldProviderId['providerId'], $oldHourId['answerId'], $oldTime['duoTime']);
                    return $this->apiResponse('Updated successfully');

                } else {
                    return $this->notFoundMassage('Booking Id');
                }
            } else {
                return $this->unAuthoriseResponse();
            }
        } catch (\Exception $exception) {
            return $this->apiResponse($exception->getMessage());
        }
    }

}
