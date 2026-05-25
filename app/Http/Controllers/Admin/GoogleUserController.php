<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class GoogleUserController extends Controller
{
    /**
     * Display a list of users who signed up via Google.
     */
    public function index()
    {
        $googleUsers = User::whereNotNull('google_id')
            ->orderBy('google_signup_at', 'desc')
            ->get();

        return view('admin.google_signups.index', compact('googleUsers'));
    }
}
?>
