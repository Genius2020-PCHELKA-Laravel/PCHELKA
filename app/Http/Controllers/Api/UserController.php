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
        }
        else {
            return  $this->unAuthoriseResponse();
        }
    }

    /**
     * Register api
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullName' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'dateOfBirth' => 'required',
            'gender' => 'required',
            'language' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('PCHELKA-Backend')->accessToken;
        $success['name'] = $user->fullName;
        return $this->apiResponse($success);
    }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return $this->apiResponse($user);
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->AauthAccessToken()->delete();
            return $this->apiResponse('Success', null, 200);
        } else {
            return $this->generalError();
        }
    }
}
