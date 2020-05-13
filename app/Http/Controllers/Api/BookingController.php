<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\BookingStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\ServicesEnum;

class BookingController extends Controller
{
    use ApiResponseTrait;

    public function BookService(Request $request)
    {
        dd($request->answers[1]['answerValue']);
    }
}
