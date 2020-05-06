<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    public $fillable = ['name', 'details', 'imgPath', 'couponId'];

    public function Coupon()
    {
        return $this->belongsTo('App\Models\Coupon', 'id');
    }

    public function Bookings()
    {
        return $this->hasMany('App\Models\Booking', 'serviceId');
    }

    public function ServicesQuestions()
    {
        return $this->hasMany('App\Models\ServicesQuestions', 'serviceId');
    }

}
