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



    public function getDaysByServiceType(Request $request)
    {

    }

    public function getSchedulesDays(Request $request)
    {
        $days = collect(Schedule::where('serviceProviderId', $request->id)->get());
        return $this->apiResponse($days);
    }

    public function getSchedulesTime(Request $request)
    {
        $time = Schedule::where('id', $request->id)->first();
        $data = ['timeStart' => $time->timeStart, 'timeEnd' => $time->timeEnd];
        return $this->apiResponse($data);
    }
}
