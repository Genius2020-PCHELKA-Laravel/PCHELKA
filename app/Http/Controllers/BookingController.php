<?php

namespace App\Http\Controllers;

use App\Enums\LanguageEnum;
use App\Enums\ServicesEnum;
use App\Http\Controllers\Api\BookingHelperTrait;
use App\Models\Booking;
use App\Models\BookingAnswers;
use App\Models\Evaluation;
use App\Models\Question;
use App\Models\ServiceProvider;
use App\Models\UserLocation;
use App\Notifications\CanceledNotification;
use App\Notifications\CompletedNotification;
use App\Notifications\EmailCancle;
use App\Notifications\EmailCompleted;
use App\Notifications\RuCanceledNotification;
use App\Notifications\RuCompletedNotification;
use Illuminate\Http\Request;
use App\Enums\BookingStatusEnum;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Log;
use mysql_xdevapi\RowResult;
use NunoMaduro\Collision\Provider;

class BookingController extends Controller
{
    use BookingHelperTrait;

    public function getAutoAssignId()
    {
        $autoAssign = ServiceProvider::where('email', 'auto@auto.auto')->first();
        if ($autoAssign) return $autoAssign->id;
        else return null;
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function All()
    {
        $bookings = array();
        $providers = ServiceProvider::all();
        $autoAssignId =$this->getAutoAssignId();
        $data = DB::table('bookings')
            ->select(['bookings.providerId', 'users.fullName', 'providers.mobileNumber', 'providers.name', 'parentId', 'bookings.id', 'bookings.refCode', 'bookings.created_at', 'bookings.serviceType', 'locationId', 'bookings.duoTime', 'bookings.duoDate', 'bookings.refCode', 'bookings.status'])
            ->join('providers', 'bookings.providerId', '=', 'providers.id')
            ->join('users', 'bookings.userId', '=', 'users.id')
            ->orderBy('duoDate', 'asc')
            ->get();
        foreach ($data as $single) {
            $userLocation = null;
            if ($single->parentId == null) {
                $userLocation = UserLocation::where('id', '=', $single->locationId)->select('address')->first();
            } else {
                $parentLocationId = Booking::where('id', $single->parentId)->first()->locationId;
                $userLocation = UserLocation::where('id', $parentLocationId)->select('address')->first();
            }
            if ($userLocation)
                $single->location = $userLocation->address;
            $single->serviceType = ServicesEnum::getKey($single->serviceType);
            $createDate = new \DateTime($single->created_at);
            $createDate = $createDate->format('Y-m-d');
            $single->BookedDate = $createDate;

            array_push($bookings, $single);
        }
        return view('admin.Booking.All', compact('bookings', 'providers', 'autoAssignId'));
    }

    public function Confirmed()
    {

        $bookings = array();
        $providers = ServiceProvider::all();
        $data = DB::table('bookings')->where('status', '=', 1)
            ->select(['providers.id as providerId','users.fullName', 'bookings.created_at', 'providers.mobileNumber', 'parentId', 'providers.name', 'bookings.id', 'bookings.refCode', 'bookings.serviceType', 'locationId', 'bookings.duoTime', 'bookings.duoDate', 'bookings.refCode', 'bookings.status'])
            ->join('providers', 'bookings.providerId', '=', 'providers.id')
            ->join('users', 'bookings.userId', '=', 'users.id')
            ->orderBy('duoDate', 'asc')
            ->get();

        $autoAssignId =$this->getAutoAssignId();
        foreach ($data as $single) {

            $userLocation = null;
            if ($single->parentId == null) {
                $userLocation = UserLocation::where('id', '=', $single->locationId)->select('address')->first();
            } else {
                $parentLocationId = Booking::where('id', $single->parentId)->first()->locationId;
                $userLocation = UserLocation::where('id', $parentLocationId)->select('address')->first();
            }
            if ($userLocation)
                $single->location = $userLocation->address;
            $single->serviceType = ServicesEnum::getKey($single->serviceType);

            $createDate = new \DateTime($single->created_at);
            $createDate = $createDate->format('Y-m-d');
            $single->BookedDate = $createDate;
            array_push($bookings, $single);
        }
        return view('admin.Booking.confirm', compact('bookings', 'providers', 'autoAssignId'));
        //
    }

    public function Completed()
    {
        $bookings = array();
        $providers = ServiceProvider::all();
        $data = DB::table('bookings')->where('status', '=', BookingStatusEnum::Completed())
            ->select(['users.fullName', 'bookings.created_at', 'providers.mobileNumber', 'parentId', 'providers.name', 'bookings.id', 'bookings.refCode', 'bookings.serviceType', 'locationId', 'bookings.duoTime', 'bookings.duoDate', 'bookings.refCode', 'bookings.status'])
            ->join('providers', 'bookings.providerId', '=', 'providers.id')
            ->join('users', 'bookings.userId', '=', 'users.id')
            ->orderBy('duoDate', 'asc')
            ->get();
        $autoAssign = ServiceProvider::where('email', 'auto@auto.auto')->first();
        if ($autoAssign) $autoAssignId = $autoAssign->id;
        foreach ($data as $single) {
            $userLocation = null;
            if ($single->parentId == null) {
                $userLocation = UserLocation::where('id', '=', $single->locationId)->select('address')->first();
            } else {
                $parentLocationId = Booking::where('id', $single->parentId)->first()->locationId;
                $userLocation = UserLocation::where('id', $parentLocationId)->select('address')->first();
            }
            if ($userLocation)
                $single->location = $userLocation->address;
            $single->serviceType = ServicesEnum::getKey($single->serviceType);

            $createDate = new \DateTime($single->created_at);
            $createDate = $createDate->format('Y-m-d');
            $single->BookedDate = $createDate;
            array_push($bookings, $single);
        }


        return view('admin.Booking.completed', compact('bookings', 'autoAssignId'));
        //
    }

    public function Rescheduled()
    {
        $bookings = array();
        $providers = ServiceProvider::all();
        $data = DB::table('bookings')->where('status', '=', BookingStatusEnum::Rescheduled())
            ->select(['providers.id as providerId', 'users.fullName', 'bookings.created_at', 'providers.mobileNumber', 'providers.name', 'bookings.id', 'bookings.refCode', 'bookings.serviceType', 'locationId', 'bookings.duoTime', 'bookings.duoDate', 'bookings.refCode', 'bookings.status', 'parentId'])
            ->join('providers', 'bookings.providerId', '=', 'providers.id')
            ->join('users', 'bookings.userId', '=', 'users.id')
            ->orderBy('duoDate', 'asc')
            ->get();

        foreach ($data as $single) {
            $userLocation = null;
            if ($single->parentId == null) {
                $userLocation = UserLocation::where('id', '=', $single->locationId)->select('address')->first();
            } else {
                $parentLocationId = Booking::where('id', $single->parentId)->first()->locationId;
                $userLocation = UserLocation::where('id', $parentLocationId)->select('address')->first();
            }
            if ($userLocation)
                $single->location = $userLocation->address;
            $single->serviceType = ServicesEnum::getKey($single->serviceType);
            $createDate = new \DateTime($single->created_at);
            $createDate = $createDate->format('Y-m-d');
            $single->BookedDate = $createDate;
            array_push($bookings, $single);
        }
        $autoAssignId =$this->getAutoAssignId();
        return view('admin.Booking.rescheduled', compact('bookings', 'providers', 'autoAssignId'));
        //
    }

    public function Canceled()
    {
        $bookings = array();
        $providers = ServiceProvider::all();
        $data = DB::table('bookings')->where('status', '=', BookingStatusEnum::Canceled())
            ->select(['users.fullName', 'bookings.created_at', 'providers.mobileNumber', 'providers.name', 'bookings.id', 'bookings.refCode', 'bookings.serviceType', 'locationId', 'bookings.duoTime', 'bookings.duoDate', 'bookings.refCode', 'bookings.status'])
            ->join('providers', 'bookings.providerId', '=', 'providers.id')
            ->join('users', 'bookings.userId', '=', 'users.id')
            ->orderBy('duoDate', 'asc')
            ->get();
        foreach ($data as $single) {
            $userLocation = UserLocation::where('id', $single->locationId)->first();
            if ($userLocation)
                $single->location = $userLocation->address;
            $single->serviceType = ServicesEnum::getKey($single->serviceType);

            $createDate = new \DateTime($single->created_at);
            $createDate = $createDate->format('Y-m-d');
            $single->BookedDate = $createDate;

            array_push($bookings, $single);
        }

        return view('admin.Booking.canceled', compact('bookings'));
        //
    }

    public function change_to_completed($id)
    {
        $booking = Booking::find($id);
        $autoId = ServiceProvider::where('email', 'auto@auto.auto')->first();
        if ($autoId) {
            if ($booking->providerId != $autoId->id) {
                $booking->status = BookingStatusEnum::Completed;
                $booking->save();
                $user = User::where('id', $booking->userId)->first();
                $user->evaluation = number_format(doubleval(Evaluation::where('serviceProviderId', $booking->id)->avg('starCount')), 1, '.', '');
                $user->bookId = $booking->id;
                $user->refCode = $booking->refCode;
                $user->image = ServiceProvider::where('id', $booking->providerId)->first()->imageUrl;
                $user->providerId = $booking->providerId;
                $user->bookStatus = BookingStatusEnum::getKey(2);
                $user->providerName = ServiceProvider::where('id', $booking->providerId)->first()->name;
                if ($user->language == LanguageEnum::ru) {
                    $completedNotification = new RuCompletedNotification();
                    $user->notify($completedNotification);
                } else {
                    $completedNotification = new CompletedNotification();
                    $user->notify($completedNotification);
                }
                $user->providerName = ServiceProvider::where('id', $booking->providerId)->first()->name;
                $user->notify(new EmailCompleted());
            }
        } else {
            $booking->status = BookingStatusEnum::Completed;
            $booking->save();

            $user = User::where('id', $booking->userId)->first();

            $user->evaluation = number_format(doubleval(Evaluation::where('serviceProviderId', $booking->id)->avg('starCount')), 1, '.', '');
            $user->bookId = $booking->id;
            $user->refCode = $booking->refCode;
            $user->image = ServiceProvider::where('id', $booking->providerId)->first()->imageUrl;
            $user->providerId = $booking->providerId;
            $user->bookStatus = BookingStatusEnum::getKey(2);
            $user->providerName = ServiceProvider::where('id', $booking->providerId)->first()->name;
            if ($user->language == LanguageEnum::ru) {
                $completedNotification = new RuCompletedNotification();
                $user->notify($completedNotification);
            } else {
                $completedNotification = new CompletedNotification();
                $user->notify($completedNotification);
            }
            $user->providerName = ServiceProvider::where('id', $booking->providerId)->first()->name;
            $user->notify(new EmailCompleted());
        }
    }

    public function change_to_canceled($id)
    {
        $booking = Booking::find($id);
        $booking->status = BookingStatusEnum::Canceled;
        $booking->save();

        $user = User::where('id', $booking->userId)->first();
        $user->refCode = $booking->refCode;
        $user->duoDate = $booking->duoDate;
        $user->douTime = $booking->douTime;
        $user->bookStatus = BookingStatusEnum::getKey(4);

        if ($user->language == LanguageEnum::ru) {
            $canceledNotification = new RuCanceledNotification();
            $user->notify($canceledNotification);
        } else {
            $canceledNotification = new CanceledNotification();
            $user->notify($canceledNotification);
        }
        $user->notify(new EmailCancle());
    }

    public function showAutoAssign()
    {
        $response = array();
        $autoId = ServiceProvider::where('email', 'auto@auto.auto')->first();
        if ($autoId) {
            $book = Booking::where('providerId', $autoId->id)
                ->where('status', BookingStatusEnum::coerce(BookingStatusEnum::Confirmed))
                ->orderBy('duoDate', 'asc')
                ->get();
            foreach ($book as $row) {
                if ($row->parentId == null) {
                    $row ['userLocation'] = UserLocation::where('id', '=', $row->locationId)->select('address')->first();
                } else {
                    $locationId = Booking::where('id', $row->parentId)->select('locationId')->first();
                    $row ['userLocation'] = UserLocation::where('id', '=', $locationId->locationId)->select('address')->first();
                }
                $row["fullName"] = User::where('id', $row->userId)->select('fullName')->first()->fullName;
                $row["name"] = ServiceProvider::where('id', $row->providerId)->select('name')->first()->name;
                $row["mobileNumber"] = ServiceProvider::where('id', $row->providerId)->select('mobileNumber')->first()->mobileNumber;
                $createDate = new \DateTime($row["created_at"]);
                $createDate = $createDate->format('Y-m-d');
                $row["BookedDate"] = $createDate;
                $row["serviceType"] = ServicesEnum::getKey($row->serviceType);

                array_push($response, $row);
            }
        }

        $autoAssignId =$this->getAutoAssignId();

        return view('admin.Booking.autoAssign', compact('response', 'autoAssignId'));
    }

    public function upComingBooking()
    {
        $response = array();
        $book = Booking::where(function ($q) {
            $q->where('status', '=', BookingStatusEnum::Confirmed())
                ->orWhere('status', '=', BookingStatusEnum::Rescheduled());
        })
            ->orderBy('duoDate', 'asc')
            ->get();

        foreach ($book as $row) {
            if ($row->parentId == null) {
                $row ['userLocation'] = UserLocation::where('id', '=', $row->locationId)->select('address')->first();
                $row["fullName"] = User::where('id', $row->userId)->select('fullName')->first()->fullName;
            } else {
                $locationId = Booking::where('id', $row->parentId)->select('locationId')->first();
                $row ['userLocation'] = UserLocation::where('id', '=', $locationId->locationId)->select('address')->first();
            }
            $row["fullName"] = User::where('id', $row->userId)->select('fullName')->first()->fullName;
            $provider = ServiceProvider::where('id', $row->providerId)->select(['name', 'mobileNumber'])->first();
            $row["name"] = $provider ? $provider->name : "Deleted Provider";
            $row["mobileNumber"] = $provider ? $provider->mobileNumber : "Deleted Provider";

            $createDate = new \DateTime($row["created_at"]);
            $createDate = $createDate->format('Y-m-d');
            $row["BookedDate"] = $createDate;
            $row["serviceType"] = ServicesEnum::getKey($row->serviceType);
            array_push($response, $row);
        }
        $autoAssignId =$this->getAutoAssignId();
        return view('admin.Booking.upComing', compact('response', 'autoAssignId'));
    }

    public function pastBooking()
    {
        $response = array();
        $book = Booking::where(function ($q) {
            $q->where('status', '=', BookingStatusEnum::Canceled())
                ->orWhere('status', '=', BookingStatusEnum::Completed());
        })
            ->orderBy('duoDate', 'asc')
            ->get();

        foreach ($book as $row) {
            if ($row->parentId == null) {
                $row ['userLocation'] = UserLocation::where('id', '=', $row->locationId)->select('address')->first();
                $row["fullName"] = User::where('id', $row->userId)->select('fullName')->first()->fullName;
            } else {
                $locationId = Booking::where('id', $row->parentId)->select('locationId')->first();
                $row ['userLocation'] = UserLocation::where('id', '=', $locationId->locationId)->select('address')->first();
            }
            $row["fullName"] = User::where('id', $row->userId)->select('fullName')->first()->fullName;
            $provider = ServiceProvider::where('id', $row->providerId)->select(['name', 'mobileNumber'])->first();
            $row["name"] = $provider ? $provider->name : "Deleted Provider";
            $row["mobileNumber"] = $provider ? $provider->mobileNumber : "Deleted Provider";

            $createDate = new \DateTime($row["created_at"]);
            $createDate = $createDate->format('Y-m-d');
            $row["BookedDate"] = $createDate;
            $row["serviceType"] = ServicesEnum::getKey($row->serviceType);
            array_push($response, $row);
        }
        $autoAssignId =$this->getAutoAssignId();
        return view('admin.Booking.pastBooking', compact('response', 'autoAssignId'));
    }

    public function getBookingById($id)
    {
        $booking = Booking::where('id', $id)->first();
        $provider = ServiceProvider::where('id', $booking->providerId)->first();

        $client = User::where('id', $booking->userId)->first();
        $response["refCode"] = $booking->refCode;
        $response["duoDate"] = $booking->duoDate;
        $response["duoTime"] = $booking->duoTime;
        $address = UserLocation::where('id', $booking->locationId)
            ->select(['address', 'details', 'area', 'street', 'buildingNumber', 'apartment'])->first();
        if ($address) {
            $response['addressDetails'] = [
                'locationId' => $booking->locationId,
                'address' => $address->address,
                'details' => $address->details,
                'area' => $address->area,
                'street' => $address->street,
                'buildingNumber' => $address->buildingNumber,
                'apartment' => $address->apartment];
        } else {
            $response['addressDetails'] = null;
        }

        $response['avgEvaluation'] = number_format(doubleval(Evaluation::where('serviceProviderId', $provider->id)->avg('starCount')), 1, '.', '');
        $response['bookingEvaluation'] = number_format(doubleval(Evaluation::where('serviceProviderId', $provider->id)
            ->where('bookingId', $id)
            ->avg('starCount')), 1, '.', '');

        $response["providerName"] = $provider->name;
        $response["providerMobileNumber"] = $provider->mobileNumber;
        $response["clientName"] = $client->fullName;
        $response["clientMobileNumber"] = $client->mobile;
        $response["serviceType"] = ServicesEnum::getKey($booking->serviceType);
        $response["status"] = BookingStatusEnum::getKey($booking->status);
        $response["totalAmount"] = $booking->totalAmount;

        $answers = null;
        if ($booking['parentId'] != null) {
            $answers = BookingAnswers::where('bookingId', $booking->parentId)->select(['id', 'bookingId', 'answerValue', 'answerId', 'questionId'])->get();
        } else {
            $answers = BookingAnswers::where('bookingId', $id)->select(['id', 'bookingId', 'answerValue', 'answerId', 'questionId'])->get();
        }
        $answerRes = array();
        foreach ($answers as $answer) {
            if ($answer['answerId']) {
                $row = [
                    'question' => Question::where('id', $answer['questionId'])->first()->name,
                    'answer' => $this->getAnswer($answer['answerId'])
                ];
            } else {
                $value = $answer['answerValue'];
                $row = [
                    'question' => Question::where('id', $answer['questionId'])->first()->name,
                    'answer' => $value
                ];
            }
            array_push($answerRes, $row);
        }
        $response['answer'] = $answerRes;

        return view('admin.Booking.bookDetiles', compact('response'));
//        foreach ($response['answer'] as $ans) {
//            dump($ans['question']);
//            dump($ans['answer']);
//        }
    }

}
