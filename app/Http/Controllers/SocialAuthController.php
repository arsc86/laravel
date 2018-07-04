<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;

class SocialAuthController extends Controller
{
    public function social($social)
    {
        return Socialite::driver($social)->redirect();
    }
    
    public function callback($social)
    {
        //dd($social);die;
        $user = Socialite::driver($social)->user();
        dd($user);
    }
}
