<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicesQuestions extends Model
{
    protected $table='services_questions';
    protected $fillable=['id','serviceId','questionId'];
}
