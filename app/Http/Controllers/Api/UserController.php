<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;


class UserController extends Controller
{
    use apiResponseTrait;
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
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('PCHELKA-Backend')->accessToken;
            return $this->apiResponse($success);
        } else {
            return $this->unAuthoriseResponse();
        }
    }

    /**
     * Register api
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try {
            $response = array();
            $input = $request->all();

            $validator = Validator::make($request->all(), [
                'fullName' => 'required',
                'email' => 'required|email',
                'gender' => 'required',
                'language' => 'required',
                'mobile' => 'required|digits:12'
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }
            $mobile = $input['mobile'];
            $user = User::where('mobile', '=', $mobile)->first();
            if ($user) {
                $user->update($request->all());
                return $this->apiResponse('Your registration has been successful', null, 200);
            } else {
                return $this->notFoundMassage();
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

    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->AauthAccessToken()->delete();
            return $this->apiResponse('Success Logout', null, 200);
        } else {
            return $this->generalError();
        }
    }
}
