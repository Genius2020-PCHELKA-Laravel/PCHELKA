<?php

namespace App\Http\Controllers;

use App\Notifications\EmailConfirm;
use App\Notifications\TestNotify;
use App\Notifications\TEstNotify2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function test()
    {

        $user=Auth::user();
        $user->notify(new EmailConfirm());

    }
}

