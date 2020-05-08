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
    public function sendSMS(Request $request){
        $response=array();
        $input = $request->all();
		if ( !isset($input['mobile'])) 
            return $this->apiResponse($response,"Invalid mobile number", 422);        
        $mobile=$input['mobile'];
        $otp=$input['otp'];

        
        $user  = User::where('mobile','=',$mobile)->first();

        if (! $user) 
            {
                $user = new \App\User();
                $user-> mobile= $input['mobile'];
                $user->isVerified = 0;
                $user->save();
                Auth::login($user, true);
            }
        
       
        if(Auth::user())
            return $this->apiResponse($response,"User is logged in", 422);

        $SPApiClient = new ApiClient(API_USER_ID, API_SECRET, new FileStorage());
    
        $phones = [ $mobile ];
        $params = [
            'sender' => 'Pchelka',
            'body' => 'Test SMS from PCHELKA Cleaning Home.. your Code is: ' . $otp
        ];
        $additionalParams = [
            'transliterate' => 0
        ];
        $response=$SPApiClient->sendSmsByList($phones, $params, $additionalParams);
        var_dump($response );
		
    } 
    public function verifySMSCode(Request $request){
        $response = array();
        $input = $request->all();
        $mobile=$input['mobile'];
        $enteredOtp=$input['enteredotp'];
        $OTP=$input['otp'];
        if(!isset($enteredOtp))
		  {
            return $this->apiResponse($response,"You Must Enter OTP.", 422);
          }
          else{
                if($OTP === $enteredOtp){
                    //if(Auth::user() && !Auth::user()->isVerified)
                    $user  = User::where('mobile','=',$mobile)->first();;
                    $user->update(['isVerified' => 1]);
                    Auth::login($user, true);
                    $response['isVerified'] = 1;
                    $response['OTP'] = $OTP;
                    return $this->apiResponse($response,"Your Number is Verified.", 200);
                }else {
                    $response['isVerified'] = 0;
                    $response['OTP'] = $OTP;
                    return $this->apiResponse($response,"OTP does not match.", 422);
                }
            }

    }         
}
