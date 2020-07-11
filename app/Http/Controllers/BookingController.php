<?php

namespace App\Http\Controllers;

use App\Enums\LanguageEnum;
use App\Http\Controllers\Api\BookingHelperTrait;
use App\Models\Booking;
use App\Models\BookingAnswers;
use App\Models\Evaluation;
use App\Models\ServiceProvider;
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

class BookingController extends Controller
{
    use BookingHelperTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function All()
    {
        $providers = ServiceProvider::all();
        $bookings = DB::table('bookings')->select(['users.fullName', 'providers.mobileNumber', 'providers.name', 'bookings.id', 'bookings.refCode', 'bookings.duoTime', 'bookings.duoDate', 'bookings.refCode', 'bookings.status'])
            ->join('providers', 'bookings.providerId', '=', 'providers.id')
            ->join('users', 'bookings.userId', '=', 'users.id')
            ->orderBy('duoDate', 'desc')
            ->get();

        return view('admin.Booking.All', compact('bookings', 'providers'));
        //
    }

    public function Confirmed()
    {
        $providers = ServiceProvider::all();


        $bookings = DB::table('bookings')->where('status', '=', 1)
            ->select(['users.fullName', 'providers.mobileNumber', 'providers.name', 'bookings.id', 'bookings.refCode', 'bookings.duoTime', 'bookings.duoDate', 'bookings.refCode', 'bookings.status', 'bookings.providerId'])
            ->join('providers', 'bookings.providerId', '=', 'providers.id')
            ->join('users', 'bookings.userId', '=', 'users.id')
            ->orderBy('duoDate', 'desc')
            ->get();

        return view('admin.Booking.confirm', compact('bookings', 'providers'));
        //
    }

    public function Completed()
    {
        $bookings = DB::table('bookings')->where('status', '=', BookingStatusEnum::Completed())->select(['users.fullName', 'providers.mobileNumber', 'providers.name', 'bookings.id', 'bookings.refCode', 'bookings.duoTime', 'bookings.duoDate', 'bookings.refCode', 'bookings.status'])
            ->join('providers', 'bookings.providerId', '=', 'providers.id')
            ->join('users', 'bookings.userId', '=', 'users.id')
            ->orderBy('duoDate', 'desc')
            ->get();
        return view('admin.Booking.completed', compact('bookings'));
        //
    }

    public function Rescheduled()
    {
        $bookings = DB::table('bookings')->where('status', '=', BookingStatusEnum::Rescheduled)
            ->select(['users.fullName', 'providers.mobileNumber', 'providers.name', 'bookings.id', 'bookings.refCode', 'bookings.duoTime', 'bookings.duoDate', 'bookings.refCode', 'bookings.status'])
            ->join('providers', 'bookings.providerId', '=', 'providers.id')
            ->join('users', 'bookings.userId', '=', 'users.id')
            ->orderBy('duoDate', 'desc')
            ->get();
        return view('admin.Booking.rescheduled', compact('bookings'));
        //
    }


    public function Canceled()
    {
        $bookings = DB::table('bookings')->where('status', '=', BookingStatusEnum::Canceled)
            ->select(['users.fullName', 'providers.mobileNumber', 'providers.name', 'bookings.id', 'bookings.refCode', 'bookings.duoTime', 'bookings.duoDate', 'bookings.refCode', 'bookings.status'])
            ->join('providers', 'bookings.providerId', '=', 'providers.id')
            ->join('users', 'bookings.userId', '=', 'users.id')
            ->orderBy('duoDate', 'desc')
            ->get();
        return view('admin.Booking.canceled', compact('bookings'));
        //
    }

    public function change_to_completed($id)
    {
        $booking = Booking::find($id);
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

    public function change_provider(Request $request, $id)
    {
        global $oldHourId;
        $booking = Booking::find($id);

        if ($booking->parentId != null) {
            $oldHourId = BookingAnswers::where('bookingId', $booking->parentId)->where('questionId', 2)
                ->orWhere('questionId', 6)->orWhere('questionId', 9)->orWhere('questionId', 12)
                ->select(['answerId'])->first();

        } else {
            $oldHourId = BookingAnswers::where('bookingId', $id)->where('questionId', 2)
                ->orWhere('questionId', 6)->orWhere('questionId', 9)->orWhere('questionId', 12)
                ->select(['answerId'])->first();
        }
        $duoDate = $booking->duoDate;
        $duoTime = $booking->duoTime;
        $newProvider = ServiceProvider::where('id', $request->input('name'))->first();
        $oldProvider = $booking->providerId;
        $booking->providerId = $newProvider->id;
        if ($oldHourId['answerId']!=null) {
            $this->deActiveSchdule($duoDate, $newProvider->id, $oldHourId['answerId'], $duoTime);
            $this->activeSchdule($duoDate, $oldProvider, $oldHourId['answerId'], $duoTime);
        }

        $booking->save();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Booking $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Booking $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Booking $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Booking $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //
    }
}
