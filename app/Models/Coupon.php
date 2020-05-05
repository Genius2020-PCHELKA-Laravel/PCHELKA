<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupons';
    protected $fillable = ['id', 'name', 'discountValue', 'validFrom', 'validUntil', 'couponCode', 'type', 'isValid'];

    public function Bookings()
    {
        return $this->hasMany('App\Models\Booking', 'couponId');
    }

    public function Services()
    {
        return $this->hasMany('App\Models\Service', 'couponId');
    }
}
