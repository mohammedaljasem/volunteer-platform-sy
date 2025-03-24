<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    // Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();
        return $this->loginOrCreateAccount($user, 'google');
    }

    // Facebook
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->stateless()->user();
        return $this->loginOrCreateAccount($user, 'facebook');
    }

    // التعامل مع الحساب
    protected function loginOrCreateAccount($providerUser, $provider)
    {
        $user = User::where('email', $providerUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'password' => bcrypt('password'), // كلمة سر وهمية
                'email_verified_at' => now(),
            ]);
        }

        Auth::login($user);

        return redirect()->intended('/');
    }
}
