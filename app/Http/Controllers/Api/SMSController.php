<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests;
use Sendpulse\RestApi\ApiClient;
use Sendpulse\RestApi\Storage\FileStorage;
use Illuminate\Support\Facades\Session;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

define('API_USER_ID', 'e2b19f6a957d7fa38d271247f6cf38ff');
define('API_SECRET', 'fce2f5757cc0831479cb53937b98ef32');
define('PATH_TO_ATTACH_FILE', __FILE__);

class SMSController extends Controller
{
    use apiResponseTrait;

    public $successStatus = 200;

    public function sendSMS(Request $request)
    {
        $response = array();
        $input = $request->all();

        #region UserInputValidate
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|digits:12',
            'otp' => 'required|digits:4',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null, ['error' => $validator->errors()], 520);
        }
        $mobile = $input['mobile'];
        $otp = $input['otp'];
        #endregion

        $user = User::where('mobile', '=', $mobile)->first();
        if (!$user) {
            $user = new \App\User();
            $user->mobile = $input['mobile'];
            $user->isVerified = 0;
            $user->save();
            Auth::login($user, true);
        }

        if (Auth::user()) {
            return $this->apiResponse($response, "User is logged in", 422);
        } else {
            #region SendSms
            $SPApiClient = new ApiClient(API_USER_ID, API_SECRET, new FileStorage());
            $phones = [$mobile];
            $params = [
                'sender' => 'Pchelka',
                'body' => 'Test SMS from PCHELKA Cleaning Home.. your Code is: ' . $otp
            ];
            $additionalParams = [
                'transliterate' => 0
            ];
            $response = $SPApiClient->sendSmsByList($phones, $params, $additionalParams);
            return $this->apiResponse($response);
            #endregion
        }

    }

    public function verifySMSCode(Request $request)
    {
        $response = array();
        $input = $request->all();
        #region UserInputValidate
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|digits:12',
            'otp' => 'required|digits:4',
            'enteredotp' => 'required|digits:4',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null, ['error' => $validator->errors()], 520);
        }
        $mobile = $input['mobile'];
        $enteredOtp = $input['enteredotp'];
        $OTP = $input['otp'];
        #endregion


        if ($OTP === $enteredOtp) {
            $user = User::where('mobile', $mobile)->first();
            if (!$user) {
                return $this->notFoundMassage();
            } else {
                $user['isVerified'] = 1;
                $user->save();
                Auth::login($user, true);

                // Creating a token without scopes...
                $token = $user->createToken('PCHELKA-Backend')->accessToken;
                $response['isVerified'] = 1;
                $response['token'] = $token;
                $response['message'] = "Your Number is Verified.";
                return $this->apiResponse($response);
            }
        } else {
            $response['isVerified'] = 0;
            $response['OTP'] = $OTP;
            return $this->apiResponse(null, "Verify code does not match.", 422);
        }


    }
}
