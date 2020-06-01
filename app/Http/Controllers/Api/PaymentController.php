<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use LiqPay;

class PaymentController extends Controller
{
    //
    use ApiResponseTrait;

    public $successStatus = 200;

    public function payment_widget_params()
    {

    }

    public function pay(Request $request)
    {
        try {
            $public_key = config('services.liqpay.public_key');
            $private_key = config('services.liqpay.private_key');
            $mobile = (string)Auth::user()->mobile;
            $liqpay = new LiqPay($public_key, $private_key);
            $res = $liqpay->api("request", array(
                'action' => 'pay',
                'version' => '3',
                'phone' => $mobile,
                'amount' => $request->amount,
                'currency' => config('services.liqpay.default_currency'),
                'description' => $request->description,
                'order_id' => $request->order_id,
                //'card'           => '4323355500580287',
                'card' => $request->card,
                'card_exp_month' => $request->card_exp_month,
                'card_exp_year' => $request->card_exp_year,
                'card_cvv' => $request->card_cvv
            ));
            ///return $res;
            return $this->apiResponse($res);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function subscribe(Request $request)
    {
        $public_key = config('services.liqpay.public_key');
        $private_key = config('services.liqpay.private_key');
        $mobile = (string)Auth::user()->mobile;
        $liqpay = new LiqPay($public_key, $private_key);
        $res = $liqpay->api("request", array(
            'action' => 'subscribe',
            'version' => '3',
            'phone' => $mobile,
            'amount' => $request->input('amount'),
            'currency' => config('services.liqpay.default_currency'),
            'description' => $request->input('description'),
            'order_id' => $request->input('order_id'),
            //'card'           => '4323355500580287',
            'subscribe' => '1',
            'subscribe_date_start' => '2015-03-31 00:00:00',
            'subscribe_periodicity' => $request->input('periodicity'),
            'card' => $request->input('card'),
            'card_exp_month' => $request->input('card_exp_month'),
            'card_exp_year' => $request->input('card_exp_year'),
            'card_cvv' => $request->input('card_cvv')
        ));
        ///return $res;
        return $this->apiResponse($res);
    }

    public function updatesubscribe(Request $request)
    {
        $public_key = config('services.liqpay.public_key');
        $private_key = config('services.liqpay.private_key');
        $mobile = (string)Auth::user()->mobile;
        $liqpay = new LiqPay($public_key, $private_key);
        $res = $liqpay->api("request", array(
            'action' => 'subscribe_update',
            'version' => '3',
            'order_id' => $request->input('order_id'),
            'amount' => $request->input('amount'),
            'currency' => config('services.liqpay.default_currency'),
            'description' => $request->input('description'),
        ));
        ///return $res;
        return $this->apiResponse($res);
    }

    public function unsubscribe(Request $request)
    {
        $public_key = config('services.liqpay.public_key');
        $private_key = config('services.liqpay.private_key');
        $mobile = (string)Auth::user()->mobile;
        $liqpay = new LiqPay($public_key, $private_key);
        $res = $liqpay->api("request", array(
            'action' => 'unsubscribe',
            'version' => '3',
            'order_id' => $request->input('order_id')
        ));
        ///return $res;
        return $this->apiResponse($res);
    }

    public function sendinvoice(Request $request)
    {
        $public_key = config('services.liqpay.public_key');
        $private_key = config('services.liqpay.private_key');
        $email = (string)Auth::user()->email;
        $liqpay = new LiqPay($public_key, $private_key);
        $res = $liqpay->api("request", array(
            'action' => 'invoice_send',
            'version' => '3',
            'email' => $email,
            'amount' => $request->input('amount'),
            'currency' => config('services.liqpay.default_currency'),
            'order_id' => $request->input('order_id'),
            'goods' => array(array(
                'amount' => 111,
                'count' => 2,
                'unit' => 'шт.',
                'name' => 'телефон'
            ))
        ));
        ///return $res;
        return $this->apiResponse($res);
    }

    public function cancelinvoice(Request $request)
    {
        $public_key = config('services.liqpay.public_key');
        $private_key = config('services.liqpay.private_key');
        $liqpay = new LiqPay($public_key, $private_key);
        $res = $liqpay->api("request", array(
            'action' => 'invoice_cancel',
            'version' => '3',
            'order_id' => $request->input('order_id')
        ));
        ///return $res;
        return $this->apiResponse($res);
    }
}
