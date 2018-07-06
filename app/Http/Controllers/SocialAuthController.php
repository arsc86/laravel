<?php

namespace App\Http\Controllers;

use App\User;
use App\SocialProfile;
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
        
        $user = Socialite::driver($social)->user();
        
        $existing = User::whereIn('users.id', function($query) use($user) {
                    $query->from('social_profiles')
                            ->select('social_profiles.user_id')
                            ->where('social_profiles.social_id', $user->id);
                })->first();

        if ($existing !== null) {
            auth()->login($existing);

            return redirect('/');
        }

        session()->flash($social.'User',$user);
        
        $view = 'users.social';
        
        return view($view,['user' => $user, 'social' => $social]);
        
    }

    public function register($social,Request $request)
    {
        
        $data = session($social.'User');

        $username = $request->input('username');

        $user = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'avatar' => $data->avatar,
            'username' => $username,
            'password' => str_random(16),
        ]);

        $profile = SocialProfile::create([
            'social_id' => $data->id,
            'user_id' => $user->id,
        ]);

        auth()->login($user);

        return redirect('/');
    }
}
