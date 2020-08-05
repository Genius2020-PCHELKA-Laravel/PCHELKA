<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BookingHelperTrait;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    use BookingHelperTrait;

    public function __construct()
    {
        $this->middleware('auth');
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
    public function create(Request $request, $id)
    {

        $beginDate = new \DateTime($request['startDate']);
        $endDate = new \DateTime($request['endDate']);
        $endDate = $endDate->modify('+1 day');
        $intervalDate = \DateInterval::createFromDateString('1 day');
        $days = new \DatePeriod($beginDate, $intervalDate, $endDate);

        $begin = new \DateTime($request['startTime']);
        $end = new \DateTime($request['endTime']);
        $end = $end->modify('+30 min');
        $interval = \DateInterval::createFromDateString('30 min');
        $times = new \DatePeriod($begin, $interval, $end);

        foreach ($days as $day) {
            foreach ($times as $time) {
                $schCount = Schedule::where('timeStart', $time->format('H:i'))
                    ->where('availableDate', $day->format('Y-m-d'))
                    ->where('serviceProviderId',$id)->first();
                if (!$schCount) {
                    $schedule = new  Schedule();
                    $schedule->availableDate = $day->format('Y-m-d');
                    $schedule->timeStart = $time->format('H:i');
                    $schedule->timeEnd = $time->format('H:i');
                    $schedule->serviceProviderId = $id;
                    $schedule->isActive = 1;
                    $schedule->isGap = 0;
                    $done = $schedule->save();
                }
            }
        }
    }

    public function delete()
    {
        DB::table('schedules')->where('availableDate', '<', date('Y-m-d'))->delete();
    }
}
