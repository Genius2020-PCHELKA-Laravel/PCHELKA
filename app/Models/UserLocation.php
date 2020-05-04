<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
    protected $table = 'user_locations';
    protected $fillable = ['id','address','lat','lon','details','area','street','buildingNumber','apartment','userId'];

}
