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
use App\Enums\LanguageEnum;
use BenSampo\Enum\Rules\EnumKey;

define('API_USER_ID', 'e2b19f6a957d7fa38d271247f6cf38ff');
define('API_SECRET', 'fce2f5757cc0831479cb53937b98ef32');
define('PATH_TO_ATTACH_FILE', __FILE__);

class SMSController extends Controller
{
    use ApiResponseTrait;

    public function sendSMS(Request $request)
    {
        try {
            $response = array();
            $input = $request->all();

            #region UserInputValidate
            $validator = Validator::make($request->all(), [
                'mobile' => 'required|digits:12',
                'otp' => 'required|digits:4',
            ]);
            if ($validator->fails()) {
                return $this->apiResponse(null, $validator->errors(), 520);
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
//                $SPApiClient = new ApiClient(API_USER_ID, API_SECRET, new FileStorage());
//                $phones = [$mobile];
//                $params = [
//                    'sender' => 'Pchelka',
                //     'body' => 'Your Code is: ' . $otp .'  PCHELKA Cleaning Home..'
//                ];
//                $additionalParams = [
//                    'transliterate' => 0
//                ];
//                $response = $SPApiClient->sendSmsByList($phones, $params, $additionalParams);
                return $this->apiResponse($response);
                #endregion
            }
            return $this->apiResponse('success');
        } catch (\Exception $exception) {
            return $this->generalError();
        }

    }

    public function verifySMSCode(Request $request)
    {
        try {
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
        } catch (\Exception $exception) {
            return $this->generalError();
        }
    }

    public function changeMobileSendSMS(Request $request)
    {
        try {
            $response = array();
            $input = $request->all();
            #region UserInputValidate
            $validator = Validator::make($request->all(), [
                'mobile' => 'required|digits:12',
                'otp' => 'required|digits:4',
            ]);
            if ($validator->fails()) {
                return $this->apiResponse(null, $validator->errors(), 520);
            }
            $mobile = $input['mobile'];
            $otp = $input['otp'];
            #endregion

            $user = Auth::user();
            $chkmobile = User::where('mobile', $request->mobile)
                ->where('id','!=',$user->id)->first();
            $email = User::where('email', $request->email)
                ->where('id','!=',$user->id)->first();
            if ($chkmobile) {
                return $this->apiResponse('Duplicated Mobile');
            }
            if ($email) {
                return $this->apiResponse('Duplicated Email');
            }
            #region SendSms
            // $SPApiClient = new ApiClient(API_USER_ID, API_SECRET, new FileStorage());
            // $phones = [$mobile];
            // $params = [
            //     'sender' => 'Pchelka',
            //     'body' => 'Your Code is: ' . $otp .'  PCHELKA Cleaning Home..'
            // ];
            // $additionalParams = [
            //     'transliterate' => 0
            // ];
            // $response = $SPApiClient->sendSmsByList($phones, $params, $additionalParams);
            #endregion
            return $this->apiResponse('success');
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
    public function changeMobileVerifySMS(Request $request)
    {
        try {
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
                $user = Auth::user();
                $user['isVerified'] = 1;
                $user->mobile = $request->mobile;
                $user->fullName = $request->fullName;
                $user->email = $request->email;
                $user->dateOfBirth = $request->dateOfBirth;
                $user->gender = $request->gender;
                $user->language = $request->language;
                $user->language = LanguageEnum::coerce($request->language);
                $user->save();
                return $this->apiResponse("Match");
            }else {
                return $this->apiResponse("Dont Match");
            }
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
