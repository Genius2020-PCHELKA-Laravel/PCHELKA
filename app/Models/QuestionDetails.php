<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionDetails extends Model
{
    protected $table = 'question_details';
    protected $fillable = ['id','name','hasCount','price','questionId'];

    public function BookingAnswers()
    {
        return $this->hasMany('App\Models\BookingAnswers', 'bookingId');
    }

    public function Question(){
        return $this->belongsTo('App\Models\Question','id');
    }
}
