<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicesQuestions extends Model
{
    protected $table = 'services_questions';
    protected $fillable = ['id', 'serviceId', 'questionId'];

    public function Service()
    {
        return $this->belongsTo('App\Models\Service', 'id');
    }

    public function Question()
    {
        return $this->belongsTo('App\Models\Question', 'id');
    }
}
