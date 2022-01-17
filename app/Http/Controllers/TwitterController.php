<?php

namespace App\Http\Controllers;

use Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TwitterController extends Controller
{
    public function redirect(){
        return Socialite::driver('twitter')->redirect();
    }

    public function callback(){
        $user = Socialite::driver('twitter')->user();
        $findUser = User::where('email', $user->getEmail())->first();

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
            
            //뷰를 반환, 사용자가 원래 요청했던 페이지로 redirection
            //원래 요청했던 페이지가 없으면 /dashboard로 redirection
            return redirect('/');
        }
    }
}
