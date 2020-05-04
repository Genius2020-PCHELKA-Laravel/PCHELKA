<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';
    protected $fillable=['id','duoDate','price','discount','totalAmount','status','clientId','serviceId','couponId'];
}
