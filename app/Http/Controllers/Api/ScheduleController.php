<?php

namespace App\Http\Controllers\Api;

use App\Enums\ServicesEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\SchedulesResource;
use App\Models\Schedule;
use App\Models\ServiceProvider;
use BenSampo\Enum\Rules\EnumKey;
use Illuminate\Http\Request;
use Validator;


class ScheduleController extends Controller
{
    use ApiResponseTrait;

    public function getSchedulesByProvidersId(Request $request)
    {
        try {
            #region UserInputValidate
            $validator = Validator::make($request->all(), [
                'id' => ['required', 'integer']
            ]);
            if ($validator->fails()) {
                return $this->apiResponse(null, $validator->errors(), 520);
            }
            #endregion
            $serviceProviderId = Schedule::where('serviceProviderId', $request->id)->get();
            if (!$serviceProviderId) {
                return $this->notFoundMassage('Provider');
            }
            return $this->apiResponse(SchedulesResource::collection($serviceProviderId));
        } catch (\Exception $exception) {
            return $this->generalError();
        }
    }

    public function getSchedulesByServiceType(Request $request)
    {
        #region UserInputValidate
        $validator = Validator::make($request->all(), [
            'serviceType' => ['required', new EnumKey(ServicesEnum::class)]
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 520);
        }
        #endregion
        $id = ServiceProvider::where("serviceType", ServicesEnum::coerce($request->serviceType))->get();
        $data = Schedule::where('serviceProviderId', $id)->first();
        return $this->apiResponse($data);
    }
}
