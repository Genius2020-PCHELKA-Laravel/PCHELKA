<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemSize extends Model
{
  protected $table = 'item_sizes';
  protected $fillable = ['id','serviceType','itemNum','itemSizeX','itemSizeY','priceOfSm','bookingId'];

  public function Booking(){
      return $this->belongsTo('App\Models\Booking','id');
  }
}
