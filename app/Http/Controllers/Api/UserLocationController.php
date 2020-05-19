<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserLocationController extends Controller
{
    use ApiResponseTrait;

    public function store(Request $request)
    {
       // try {
            #region ValidateUserInput
            $validator = Validator::make($request->all(), [
                'address' => ['required'],
                'lat' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
                'lon' =>  ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
                'details' => 'required',
                'area' => 'required',
                'street' => 'required',
                'buildingNumber' => 'required',
                'apartment' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->apiResponse(null, $validator->errors(), 401);
            }
            #endregion

            if (Auth::user()) {
                $user = Auth::user();
               $userId =$user['id'];
                $userLocation = new UserLocation();
                $userLocation->address = $request->address;
                $userLocation->lat = $request->lat;
                $userLocation->lon = $request->lon;
                $userLocation->details = $request->details;
                $userLocation->area = $request->area;
                $userLocation->street = $request->street;
                $userLocation->buildingNumber = $request->buildingNumber;
                $userLocation->apartment = $request->apartment;
                $userLocation->userId =$userId;
                $userLocation->save();
            } else {
                return $this->unAuthoriseResponse();
            }
            return $this->apiResponse('User location added successfully');
//        } catch (\Exception $exception) {
//            return $this->generalError();
//        }
    }
}
