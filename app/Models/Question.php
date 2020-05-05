<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $fillable = ['id', 'name', 'type', 'price'];

    public function BookingAnswers()
    {
        return $this->hasMany('App\Models\BookingAnswers', 'questionId');
    }

    public function QuestionsDetails()
    {
        return $this->hasMany('App\Models\QuestionDetails', 'questionId');
    }

    public function ServicesQuestions()
    {
        return $this->hasMany('App\Models\ServicesQuestions', 'serviceId');
    }
}
