<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $table = 'evaluations';
    protected $fillable = ['id', 'starCount', 'userId', 'serviceProviderId', 'bookingId'];

    public function User()
    {
        return $this->hasOne('App\User', 'id');
    }
    public function Booking()
    {
        return $this->belongsTo('App\Models\Booking', 'id');
    }
    public function ServiceProvider()
    {
        return $this->belongsTo('App\User\ServiceProvider', 'id');
    }
}
