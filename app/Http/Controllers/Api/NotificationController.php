<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use App\Notifications;
use App\Notifications\ExpoNotification;
use App\User;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
        use ApiResponseTrait;
   //
     //public function sendNotification(Request $request){
    //     $user=Auth::user();
    //     $key = "ExponentPushToken[rplFsYMBUnIcHy8J-jPsXV]";
    //     $userId = $user->id;
    //     $title="title";
    //     $msg="xxxxxxxx xxxxxxxxxxxx";
    //     $notification = ['title' => $title,'body' => $msg];
    //     try{

    //         $expo = \ExponentPhpSDK\Expo::normalSetup();
    //         //$expo->notify('https://exp.host/--/api/v2/push/send',$notification);//$userId from database
    //             $expo->notify($userId,$notification);//$userId from database
    //         $status = 'success';
    //     }catch(Exception $e){
    //             $expo->subscribe($userId, $key); //$userId from database
    //             $expo->notify($userId,$notification);
    //             $status = 'new subscribtion';
    //     }
    // }
     public function sendNotification(Request $request)
     {
        $response = array();
        try {
            $user = Auth::user();
            // $expo = \ExponentPhpSDK\Expo::normalSetup();
           
            //$user=User::where('email', 'tt@tt.tt')->first();
            $exponotification=new ExpoNotification();
             $user->notify($exponotification);

             return $this->apiResponse($exponotification);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
        
        
        
 
        
        
        
        
        // try{
        //  //$user = Auth::user();
        //  //$uid=(string)$user->id;
        // //  $expotoken=$request->expotoken;
        // $interestDetails = ['PCHELKA', 'ExponentPushToken[rplFsYMBUnIcHy8J-jPsXV]'];
        // // You can quickly bootup an expo instance
        // $expo = \ExponentPhpSDK\Expo::normalSetup();
        
        // // Subscribe the recipient to the server
        // $expo->subscribe($interestDetails[0], $interestDetails[1]);
        
        // // Build the notification data
        // // $notification = ['body' => 'Hello World!', 'priority'=>'high', 'sound'=>'default', 'channelId'=>'test'];
        //  $notification = ['body' => 'Hello World!', 'data'=> json_encode(array('someData' => 'goes here')), 'android'=> json_encode(array('channelId' => 'PCHELKA', 'priority'=> 'max')) ];
        // //$notification=new ExpoNotification();
        //     // Notify an interest with a notification
        // $expo->notify($interestDetails[0], $notification);
        
        // return $this->apiResponse($notification);
        // }catch (\Exception $e){
        //     return $e->getMessage();
        // }
        
        
        
        
        
        //     $payload=array(
        //       'to' => "ExponentPushToken[rplFsYMBUnIcHy8J-jPsXV]",
        //       'title'=>'hello',
        //       'channelId': 'chat-messages',
        //       'priority': 'max',
        //       'badge'=> 1,
        //       'sound' => 'default',
        //       'body'=>'hello world'
        //     );
        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => "https://exp.host/--/api/v2/push/send",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "POST",
        //     CURLOPT_POSTFIELDS => json_encode($payload),
        //     CURLOPT_HTTPHEADER => array(
        //         "Accept: application/json",
        //         "Accept-Encoding: gzip, deflate",
        //         "Content-Type: application/json",
        //         "cache-control: no-cache",
        //         "host: exp.host"
        //     ),
        // ));

        // $response = curl_exec($curl);

        // $err = curl_error($curl);

        // curl_close($curl);

        // if ($err) {
        //     return $err;
        // } else {
        //     return $response;
        // }
        
        
        
    //     $channelName = 'news';
    // $recipient= 'ExponentPushToken[rplFsYMBUnIcHy8J-jPsXV]';
    
    // // You can quickly bootup an expo instance
    // $expo = \ExponentPhpSDK\Expo::normalSetup();
    
    // // Subscribe the recipient to the server
    // $expo->subscribe($channelName, $recipient);
    
    // // Build the notification data
    // $notification = ['body' => 'Hello World!', 'sound'=>'default'];
    
    // // Notify an interest with a notification
    // $expo->notify([$channelName], $notification);
    }
}
