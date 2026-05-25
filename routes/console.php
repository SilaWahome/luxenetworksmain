<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Blog;
use App\Models\User;
use App\Mail\BlogSharedMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Daily cron job at 9 AM to send any blogs published in the last 24 hours to subscribers
Schedule::call(function () {
    // Get blogs created in the last 24 hours
    $recentBlogs = Blog::where('created_at', '>=', Carbon::now()->subHours(24))->get();

    if ($recentBlogs->isNotEmpty()) {
        $subscribers = \App\Models\Subscriber::all();

        foreach ($recentBlogs as $blog) {
            foreach ($subscribers as $sub) {
                Mail::to($sub->email)->queue(new BlogSharedMail($blog, $sub->id));
            }
        }
    }
})->dailyAt('09:00');
