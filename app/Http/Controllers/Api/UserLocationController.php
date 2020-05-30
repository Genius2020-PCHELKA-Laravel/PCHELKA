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
        $response = array();
//        try {
//            #region ValidateUserInput
//            $validator = Validator::make($request->all(), [
//                'address' => ['required'],
//                'lat' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
//                'lon' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
//                'details' => 'required',
//                'area' => 'required',
//                'street' => 'required',
//                'buildingNumber' => 'required',
//                'apartment' => 'required',
//            ]);
//            if ($validator->fails()) {
//                return $this->apiResponse(null, $validator->errors(), 401);
//            }
         //   #endregion

            if (Auth::user()) {
                $user = Auth::user();
                $userId = $user['id'];
                $userLocation = new UserLocation();
                $userLocation->address = $request->address;
                $userLocation->lat = $request->lat;
                $userLocation->lon = $request->lon;
                $userLocation->details = $request->details;
                $userLocation->area = $request->area;
                $userLocation->street = $request->street;
                $userLocation->buildingNumber = $request->buildingNumber;
                $userLocation->apartment = $request->apartment;
                $userLocation->userId = $userId;
                $userLocation->save();
                $response['locationId'] =$lastId = intval($userLocation->id);
            } else {
                return $this->unAuthoriseResponse();
            }
            return $this->apiResponse($response);
//        } catch (\Exception $exception) {
//            return $this->generalError();
//        }
    }

    public function getUserLocations()
    {
        try {
            if (Auth::user()) {
                $user = Auth::user();
                $data = UserLocation::where('userId', $userId = $user['id'])->get();
                if ($data) {
                    return $this->apiResponse($data);
                } else {
                    return $this->notFoundMassage('Locations');
                }
            } else {
                return $this->unAuthoriseResponse();
            }
        } catch (\Exception $exception) {
            return $this->generalError();
        }
    }

    public function deleteLocation(Request $request)
    {
        try {
            #region UserInputValidate
            $validator = Validator::make($request->all(), [
                'id' => ['required', 'integer'],]);
            if ($validator->fails()) {
                return $this->apiResponse(null, $validator->errors(), 520);
            }
            #endregion
            if (Auth::user()) {
                $user = Auth::user();

                $data = UserLocation::find($request->id);
                if ($data) {
                    $data->delete();
                    return $this->apiResponse('Delete successfully');
                } else {
                    return $this->notFoundMassage('Location');
                }
            } else {
                return $this->unAuthoriseResponse();
            }
        } catch (\Exception $exception) {
            return $this->generalError();
        }
    }

    public function updateLocation(Request $request)
    {

        try {
            #region ValidateUserInput
            $validator = Validator::make($request->all(), [
                'id' => ['required', 'integer'],
                'address' => ['required'],
                'lat' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
                'lon' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
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
                $location = UserLocation::find($request->id);
                if ($location) {
                    $location->address = $request->address;
                    $location->lat = $request->lat;
                    $location->lon = $request->lon;
                    $location->details = $request->details;
                    $location->area = $request->area;
                    $location->street = $request->street;
                    $location->buildingNumber = $request->buildingNumber;
                    $location->apartment = $request->apartment;
                    $location->update();
                    return $this->apiResponse('Update successfully');
                } else {
                    return $this->notFoundMassage('Location');
                }
            } else {
                return $this->unAuthoriseResponse();
            }
        } catch (\Exception $exception) {
            return $this->generalError();
        }
    }
}
