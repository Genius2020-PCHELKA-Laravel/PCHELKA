<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingAnswers extends Model
{
    protected $table = 'booking_answers';
    protected $fillable = ['id', 'answerValue', 'count', 'itemPrice', 'totalAmount', 'answerId', 'questionId', 'bookingId'];

    public function QuestionDetails()
    {
        return $this->belongsTo('App\Models\QuestionDetails', 'id');
    }

    public function Booking()
    {
        return $this->belongsTo('App\Models\Booking', 'id');
    }

    public function Question()
    {
        return $this->belongsTo('App\Models\Questions', 'id');
    }
}
