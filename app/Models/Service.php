<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table='services';
    public $fillable=['id','name','details','imgPath','couponId'];

    public function Coupon (){
        return $this->belongsTo('App\Models\Coupon','id');
    }


}
