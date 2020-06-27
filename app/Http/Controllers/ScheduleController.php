<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
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
                    ->where('availableDate', $day->format('Y-m-d'))->first();
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
     * @param \App\Models\Schedule $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Schedule $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Schedule $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Schedule $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        //
    }
}
