<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    public function redirect() {
        return Socialite::driver('google')->redirect();
    }

    public function handleCallback() {
        $google_user = Socialite::driver('google')->user();

        $user = User::updateOrCreate([
            'google_id' => $google_user->id,
            'email' => $google_user->email,
        ], [
            'first_name' => $google_user->user['given_name'],
            'last_name' => $google_user->user['family_name'],
            'password' => Hash::make(Str::random(12))
        ]);
        
        Auth::login($user);
    
        return to_route('home');
    }
}
