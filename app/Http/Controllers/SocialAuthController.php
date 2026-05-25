<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\BlogWelcomeMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to Google's OAuth page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->redirectUrl(config('services.google.redirect'))
            ->redirect();
    }

    /**
     * Obtain the user information from Google and log them in.
     */
    public function handleGoogleCallback(Request $request)
    {
        // Retrieve user info from Google (stateless to avoid session issues)
        $googleUser = Socialite::driver('google')
            ->stateless()
            ->redirectUrl(config('services.google.redirect'))
            ->user();

        // Find existing user or create a new one
        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'first_name'   => $googleUser->user['given_name'] ?? '',
                'second_name'  => $googleUser->user['family_name'] ?? '',
                'company_name' => 'Google OAuth',
                'phone_number' => '0000000000',
                // Assign a random password – not used for OAuth logins
                'password' => bcrypt(Str::random(24)),
                'google_id' => $googleUser->getId(),
                'google_signup_at' => now(),
            ]
        );

        // Sync to Mailing List (Subscribers table)
        \App\Models\Subscriber::firstOrCreate(
            ['email' => $user->email],
            ['name' => $user->first_name . ' ' . $user->second_name]
        );

        // Log the user in
        Auth::login($user, true);

        // Send a welcome e‑mail specific to blog access
        Mail::to($user->email)->send(new BlogWelcomeMail());

        // Redirect to the homepage or wherever you prefer
        return redirect('/');
    }
}
