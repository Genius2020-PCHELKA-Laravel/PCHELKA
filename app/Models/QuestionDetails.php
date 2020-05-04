<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionDetails extends Model
{
    protected $table = 'question_details';
    protected $fillable = ['id','name','hasCount','price','questionId'];
}
