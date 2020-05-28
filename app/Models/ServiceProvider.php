<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model
{
    protected $table = 'providers';
    protected $fillable = ['id', 'name', 'email', 'mobileNumber', 'type'];

    public function Schedules()
    {
        return $this->hasMany('App\Models\Schedule','serviceProviderId');
    }
    public function Evaluations()
    {
        return $this->hasMany('App\Models\Evaluation', 'serviceProviderId');
    }
}
