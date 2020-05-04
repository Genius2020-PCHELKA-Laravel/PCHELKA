<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientLocations extends Model
{
    protected $table = 'client_locations';
    protected $fillable = ['id','address','lat','lon','details','area','street','buildingNumber','apartment','clientId'];
}
