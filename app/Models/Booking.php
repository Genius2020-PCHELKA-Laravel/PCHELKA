<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';
    protected $fillable = [
        'id',
        'duoDate',
        'duoTime',
        'subTotal',
        'discount',
        'totalAmount',
        'paidStatus',
        'paymentWays' ,
        'status',
        'serviceType',
        'userId',
        'serviceId',
        'couponId',
        'parentId',
        'locationId',
        'providerId'
        ,'scheduleId'];

    public function Coupon()
    {
        return $this->belongsTo('App\Models\Coupon', 'id');
    }

    public function Service()
    {
        return $this->belongsTo('App\Models\Service', 'id');
    }

    public function User()
    {
        return $this->belongsTo('App\User', 'id');
    }

    public function BookingAnswers()
    {
        return $this->hasMany('App\Models\BookingAnswers', 'bookingId');
    }

    public function Evaluations()
    {
        return $this->hasMany('App\Models\Evaluation', 'bookingId');
    }

    public function ItemsSize()
    {
        return $this->hasMany('App\Models\ItemSize', 'bookingId');
    }
}
