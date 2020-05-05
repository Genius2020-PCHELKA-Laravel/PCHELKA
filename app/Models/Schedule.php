<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';
    protected $fillable = ['id', 'availableDate', 'timeStart', 'timeEnd', 'serviceProviderId'];

    public function ServiceProvider()
    {
        return $this->belongsTo('App\Models\ServiceProvider','id');
    }
}
