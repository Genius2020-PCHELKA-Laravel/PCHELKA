<?php

namespace App\Http\Controllers\Api;

use App\Enums\ServicesEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProviderResource;
use App\Models\ServiceProvider;
use BenSampo\Enum\Rules\EnumKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;


class ServiceProviderController extends Controller
{
    use ApiResponseTrait;

    public function getProvidersByServiceType(Request $request)
    {
        try {
            $res = DB::table('providers')->select(['providers.id', 'name', 'imageUrl'])
                ->join('providerservices', 'providers.id', '=', 'providerservices.provider_id')
                ->where('providerservices.service_id', '=', ServicesEnum::coerce($request->serviceType))
                ->get();
            return $this->apiResponse($res);
        } catch (\Exception $exception) {
            return $this->apiResponse($exception->getMessage());
        }
    }
}
