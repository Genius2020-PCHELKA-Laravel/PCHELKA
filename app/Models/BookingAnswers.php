<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingAnswers extends Model
{
    protected $table = 'booking_answers';
    protected $fillable = ['id','answerValue','count','itemPrice','totalAmount','answerId','questionId','bookingId'];
}
