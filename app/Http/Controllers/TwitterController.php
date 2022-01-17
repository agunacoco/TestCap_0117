<?php

namespace App\Http\Controllers;

use Socialite;
use Illuminate\Http\Request;

class TwitterController extends Controller
{
    public function redirect(){
        return Socialite::driver('twitter')->redirect();
    }

    public function callback(){
        $user = Socialite::driver('twitter')->user();
    }
}
