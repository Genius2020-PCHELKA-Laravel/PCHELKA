<?php

namespace App\Http\Controllers\Api;

use App\Enums\ServicesEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProviderResource;
use App\Models\Booking;
use App\Models\Evaluation;
use App\Models\ServiceProvider;
use BenSampo\Enum\Rules\EnumKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use function GuzzleHttp\Psr7\str;


class ServiceProviderController extends Controller
{
    use ApiResponseTrait;

    public function getProvidersByServiceType(Request $request)
    {
        try {
            if (Auth::user()) {
                $user = Auth::user()->id;
                $response = array();
                $res = DB::table('providers')->select(['providers.id', 'name', 'imageUrl'])
                    ->join('providerservices', 'providers.id', '=', 'providerservices.provider_id')
                    ->where('providerservices.service_id', '=', ServicesEnum::coerce($request->serviceType))
                    ->get();
                $result = json_decode($res, true);
                foreach ($result as $newData) {
                    $row = [
                        'id' => $newData['id'],
                        'name' => $newData['name'],
                        'imageUrl' => $newData['imageUrl'],
                        'evaluation' => intval(Evaluation::where('serviceProviderId', $newData['id'])->avg('starCount')),
                        'desc' => Booking::where('userId', $user)->where('providerId', $newData['id'])->first() ? true : false
                    ];
                    array_push($response, $row);
                }
                return $this->apiResponse($response);
            } else {
                return $this->unAuthoriseResponse();
            }
        } catch (\Exception $exception) {
            return $this->apiResponse($exception->getMessage());
        }
    }
}
