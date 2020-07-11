<?php

namespace App\Http\Controllers\Api;

use App\Enums\BookingStatusEnum;
use App\Enums\ServicesEnum;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;


class ServiceProviderController extends Controller
{
    use ApiResponseTrait;

    public function getProvidersByServiceType(Request $request)
    {
        // try {
        if (Auth::user()) {
            $response = array();
            $providers = array();
            $user = Auth::user()->id;
            $bookProvider = Booking::where('userId', $user)->where('status',BookingStatusEnum::Completed)->select(['providerId', 'serviceType'])->get();
            if ($bookProvider) {
                foreach ($bookProvider as $provider) {
                    $res = array();
                    $res = DB::table('providers')->select(['providers.id', 'name', 'imageUrl'])->distinct()
                        ->join('providerservices', 'providers.id', '=', 'providerservices.provider_id')
                        ->where('providerservices.service_id', '=', ServicesEnum::coerce($request->serviceType))
                        ->where('providers.id', '=', $provider['providerId'])
                        ->first();
                    $res->service = $provider['serviceType'];
                    array_push($providers, $res);

                }
            }
            $collection = collect($providers);
            $providers = $collection->unique()->values()->all();
            $result = json_encode($providers, true);
            foreach ($providers as $newData) {
                /**SELECT duoDate FROM `bookings` WHERE userId=3
                 * and status =1
                 * and providerId =1
                 * and serviceType =12
                 * ORDER BY `duodate` DESC**/
                $lastServiceDate = Booking::where('userId', $user)->where('providerId', $newData->id)
                    ->where('status', BookingStatusEnum::Completed)
                    ->where('serviceType', ServicesEnum::coerce($request->serviceType))->orderBy('duoDate', 'DESC')
                    ->select('duoDate')->first();
                $row = [
                    'id' => $newData->id,
                    'name' => $newData->name,
                    'imageUrl' => $newData->imageUrl,
                    'evaluation' => number_format(doubleval(Evaluation::where('serviceProviderId', $newData->id)->avg('starCount')),1,'.',''),
                    'desc' => Booking::where('userId', $user)->where('providerId', $newData->id)->first() ? true : false,
                    'lastServiceDate' => $lastServiceDate['duoDate']
                ];

                if ($newData->service == ServicesEnum::getValue($request->serviceType))
                    array_push($response, $row);
            }
            return $this->apiResponse($response);
        } else {
            return $this->unAuthoriseResponse();
        }
//        } catch (\Exception $exception) {
//            return $this->apiResponse($exception->getMessage());
//        }
    }

    public function evaluation(Request $request)
    {
        if (Auth::user()) {
            $bookId = $request->bookId;
            $starCount = $request->starCount;
            if ($bookId) {
                $data = Booking::where('id', $bookId)->first();
                $evaluation = new Evaluation();
                $evaluation->starCount = $starCount;
                $evaluation->bookingId = $bookId;
                $evaluation->userId = $data->userId;
                $evaluation->serviceProviderId = $data->providerId;
                $evaluation->save();
                return $this->apiResponse('Evaluation Added Success');

            } else {
                $this->apiResponse('Please select correct booking');
            }


        } else {
            $this->unAuthoriseResponse();
        }
    }
}
