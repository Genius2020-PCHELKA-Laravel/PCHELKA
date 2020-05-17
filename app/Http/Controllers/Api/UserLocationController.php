<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLocationController extends Controller
{
    public function store(Request $request)
    {
        //Validate
        $userLocation= new UserLocation();
        $userLocation->address=$request->address;
        $userLocation->lat=$request->lat;
        $userLocation->lon=$request->lon;
        $userLocation->details=$request->details;
        $userLocation->area=$request->area;
        $userLocation->street=$request->street;
        $userLocation->buildingNumber=$request->buildingNumber;
        $userLocation->apartment=$request->apartment;
        $userLocation->userId=$request->userId;
        $userLocation->save();

    }
}
