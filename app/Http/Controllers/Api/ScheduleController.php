<?php

namespace App\Http\Controllers\Api;

use App\Enums\ServicesEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProviderResource;
use App\Http\Resources\SchedulesResource;
use App\Models\Schedule;
use App\Models\ServiceProvider;
use BenSampo\Enum\Rules\EnumKey;
use Illuminate\Http\Request;
use Validator;


class ScheduleController extends Controller
{
    use ApiResponseTrait;


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

    public function getSchedules()
    {
        try {

            $from = date('Y-m-d');

            $to = date('Y-m-d', strtotime("+15 days"));
            $sch = Schedule::whereBetween('availableDate', [$from, $to])
                ->where('isActive', true)->select(['id', 'availableDate', 'timeStart', 'timeEnd', 'serviceProviderId'])
                ->get();

            return $this->apiResponse($sch);
        } catch (\Exception $exception) {
            return $this->apiResponse($exception->getMessage());
        }
    }
}
