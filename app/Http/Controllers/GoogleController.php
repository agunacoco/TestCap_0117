<?php

namespace App\Http\Controllers;

use Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GoogleController extends Controller
{

    public function redirect(){
        return Socialite::driver('google')->redirect();
    }

    public function callback(){

        $user = Socialite::driver('google')->user();
        $findUser = User::where('email', $user->getEmail())->first();
        dd($user);
        if($findUser){
            Auth::login($findUser);
            return redirect('/');
        }else{
            $newUser = User::Create([
                'email' => $user->getEmail(),
                'password' => Hash::make(Str::random(24)), //24자 랜덤 비밀번호를 주세요.
                'name' => $user->getName()
            ]);
            //로그인 처리
            Auth::login($newUser);

            return redirect('/');
        }
        
        
    }
}
