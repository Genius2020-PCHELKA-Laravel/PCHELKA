<?php

namespace App\Http\Controllers\Api;

use App\Enums\ServicesEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProviderResource;
use App\Models\ServiceProvider;
use BenSampo\Enum\Rules\EnumKey;
use Illuminate\Http\Request;
use Validator;


class ServiceProviderController extends Controller
{
    use ApiResponseTrait;

    public function getProvidersByServiceType(Request $request)
    {
        //Validate
        $validator = Validator::make($request->all(), [
            'serviceType' => ['required', new EnumKey(ServicesEnum::class)]
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 520);
        }
        $data = ServiceProvider::where("serviceType", ServicesEnum::coerce($request->serviceType))->get();
        return $this->apiResponse(ProviderResource::collection($data), null, 200);
    }
}
