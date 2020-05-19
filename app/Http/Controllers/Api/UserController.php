<?php

namespace App\Http\Controllers\Api;

use App\Models\UserLocation;
use BenSampo\Enum\Rules\EnumKey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Enums\LanguageEnum;


class UserController extends Controller
{
    use ApiResponseTrait;

    public $successStatus = 200;


    public function validateForPassportPasswordGrant($password)
    {
        return true;
    }

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        try {
            if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
                $user = Auth::user();
                $success['token'] = $user->createToken('PCHELKA-Backend')->accessToken;
                return $this->apiResponse($success);
            } else {
                return $this->unAuthoriseResponse();
            }
        } catch (\Exception $exception) {
            return $this->generalError();
        }
    }

    /**
     * Register api
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'fullName' => 'required',
                'email' => 'required|email',
                'language' => 'required',
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

            if (Auth::user()) {
                $user = Auth::user();
                $userId =$user['id'];
                $user->fullName = $request->fullName;
                $user->email = $request->email;
                $user->language = LanguageEnum::coerce($request->language);
                $user->save();
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
                return $this->apiResponse('Your registration has been successful', null, 200);
            } else {
                return $this->unAuthoriseResponse();
            }

        } catch (\Exception $exception) {
            return $this->generalError();
        }
    }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        try {
            $user = Auth::user();
            if ($user)
                return $this->apiResponse($user);
            else
                return $this->notFoundMassage();
        } catch (\Exception $exception) {
            return $this->generalError();
        }
    }

    /**
     * Logout api
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        try {
            if (Auth::check()) {
                Auth::user()->AauthAccessToken()->delete();
                return $this->apiResponse('Success Logout', null, 200);
            } else {
                return $this->generalError();
            }
        } catch (\Exception $exception) {
            return $this->generalError();
        }
    }

    public function getUserLanguage()
    {
        try {
            if (Auth::check()) {
                $user = Auth::user();
                $language = LanguageEnum::coerce($user->language);
                return $this->apiResponse($language->key, null, 200);
            }
            return $this->unAuthoriseResponse();
        } catch (\Exception $exception) {
            return $this->generalError();
        }
    }

    public function updateUserLanguage(Request $request)
    {
        try {
            $input = $request->all();
            #region UserInputValidate
            $validator = Validator::make($request->all(), [
                'language' => ['required', new EnumKey(LanguageEnum::class)]
            ]);
            if ($validator->fails()) {
                return $this->apiResponse(null, $validator->errors(), 520);
            }
            #endregion

            $language = $input['language'];
            if (Auth::check()) {
                $user = Auth::user();
                $user['language'] = LanguageEnum::coerce($language);
                $user->save();
                return $this->apiResponse('Language update successfully ', null, 200);
            }


            return $this->unAuthoriseResponse();
        } catch (\Exception $exception) {
            return $this->generalError();
        }
    }

    public function updateUserInformation(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'fullName' => 'required',
                'email' => 'required|email',
                'language' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->apiResponse(null, $validator->errors(), 401);
            }

            if (Auth::user()) {
                $user = Auth::user();
                $user->fullName = $request->fullName;
                $user->email = $request->email;
               // $user->dateOfBirth = $request->dateOfBirth;
                $user->language = $request->language;
                $user->language = LanguageEnum::coerce($request->language);
                $user->save();
                return $this->apiResponse('User information update has been successful', null, 200);
            } else {
                return $this->unAuthoriseResponse();
            }

        } catch (\Exception $exception) {
            return $this->generalError();
        }
    }
}
