<?php

namespace App\Http\Controllers\Api;

use App\Enums\BookingStatusEnum;
use App\Enums\ServicesEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProviderResource;
use App\Http\Resources\SchedulesResource;
use App\Models\Booking;
use App\Models\Schedule;
use App\Models\ServiceProvider;
use BenSampo\Enum\Rules\EnumKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\This;
use Validator;


class ScheduleController extends Controller
{
    use ApiResponseTrait;
    use BookingHelperTrait;

    public function getSchedulesDays(Request $request)
    {
        try {
            $days = collect(Schedule::where('serviceProviderId', $request->id)
                ->select(['availableDate'])
                ->distinct()
                ->get());
            return $this->apiResponse($days);
        } catch (\Exception $exception) {
            return $this->apiResponse($exception->getMessage());
        }
    }

    public function getSchedulesTime(Request $request)
    {
        try {
            $time = Schedule::where('serviceProviderId', $request->id)
                ->where('availableDate', $request->day)
                ->where('isActive', true)
                ->select('timeStart')
                ->get();

            return $this->apiResponse($time);
        } catch (\Exception $exception) {
            return $this->apiResponse($exception->getMessage());
        }
    }

    public function getSchedules(Request $request)
    {
        try {

            $from = date('Y-m-d');
            $to = date('Y-m-d', strtotime("+15 days"));

            $begin = new \DateTime($from);
            $end = new \DateTime($to);
            $interval = \DateInterval::createFromDateString('1 day');
            $period = new \DatePeriod($begin, $interval, $end);

            foreach ($period as $dt) {
                $date = $dt->format("Y-m-d");
                $this->removeGap($request->id, $date);
            }

            $sch = Schedule::whereBetween('availableDate', [$from, $to])
                ->where('serviceProviderId', $request->id)
                ->where('isActive', true)
                ->select(['id', 'availableDate', 'timeStart', 'timeEnd', 'serviceProviderId'])
                ->get();


            return $this->apiResponse($sch);
        } catch (\Exception $exception) {
            return $this->apiResponse($exception->getMessage());
        }
    }

    public function tt(Request $request)
    {
        $beginDate = new \DateTime($request->startDate);
        $endDate = new \DateTime($request->endDate);
        $endDate = $endDate->modify('+1 day');
        $intervalDate = \DateInterval::createFromDateString('1 day');
        $days = new \DatePeriod($beginDate, $intervalDate, $endDate);

        $begin = new \DateTime($request->startTime);
        $beginFormat = $begin->format("H:i");
        $end = new \DateTime($request->endTime);

        $end = $end->modify('+30 min');
        $endFormat = $end->format("H:i");
        $interval = \DateInterval::createFromDateString('30 min');
        $times = new \DatePeriod($begin, $interval, $end);


        foreach ($days as $day) {
            foreach ($times as $time) {
                $schCount = Schedule::where('timeStart', $time->format('H:i'))
                    ->where('availableDate', $day->format('Y-m-d'))->where('serviceProviderId', $request->id)->first();
                if (!$schCount) {
                    $schedule = new  Schedule();
                    $schedule->availableDate = $day->format('Y-m-d');
                    $schedule->timeStart = $time->format('H:i');
                    $schedule->timeEnd = $time->format('H:i');
                    $schedule->serviceProviderId = $request->id;
                    $schedule->isActive = 1;
                    $schedule->isGap = 0;
                    $done = $schedule->save();
                }
            }
        }
    }

    public function testss(Request $request)
    {

    }

}

