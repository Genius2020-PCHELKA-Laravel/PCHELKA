<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'fullName', 'email', 'email_verified_at', 'password', 'dateOfBirth', 'gender','language'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function UserLocations()
    {
        return $this->hasMany('App/Models/UserLocations', 'userId');
    }

    public function Bookings()
    {
        return $this->hasMany('App\Models\Booking', 'userId');
    }

    public function Evaluations()
    {
        return $this->hasMany('App\Models\Evaluation', 'userId');
    }

    public function AauthAccessToken(){
        return $this->hasMany('App\Models\OauthAccessToken');
    }
}
