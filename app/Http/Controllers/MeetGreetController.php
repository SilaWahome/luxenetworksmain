<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MeetGreetSlide;
use App\Models\MeetGreetAnnouncement;
use App\Models\MeetGreetApplication;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class MeetGreetController extends Controller
{
    // Frontend View
    public function index()
    {
        $slides = MeetGreetSlide::orderBy('order')->get();
        $announcements = MeetGreetAnnouncement::where('is_active', true)->latest()->get();
        $settings = Setting::whereIn('key', ['event_date', 'event_time', 'event_location'])->get()->pluck('value', 'key');
        return view('meet-greet', compact('slides', 'announcements', 'settings'));
    }

    public function showRegister()
    {
        $settings = Setting::whereIn('key', ['event_date', 'event_time', 'event_location'])->get()->pluck('value', 'key');
        
        $location = $settings['event_location'] ?? 'Kampala Tech Meetup';
        $date = $settings['event_date'] ?? 'TBA';
        $time = $settings['event_time'] ?? 'TBA';
        $activeInstance = "{$location} ({$date} @ {$time})";

        return view('meet-greet.register', compact('settings', 'activeInstance'));
    }

    // Handle Applications
    public function apply(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'organization' => 'nullable|string|max:255',
            'motivation' => 'nullable|string',
            'event' => 'required|string|max:255',
        ]);

        MeetGreetApplication::create($validated);

        return back()->with('success', 'Application submitted successfully! You can now <a href="'.url('Techmeet/index.php').'" style="color: white; text-decoration: underline; font-weight: 700;">get your ticket here</a>.');
    }

    // Admin Management Dashboard
    public function adminIndex()
    {
        $slides = MeetGreetSlide::orderBy('order')->get();
        $announcements = MeetGreetAnnouncement::latest()->get();
        $applications = MeetGreetApplication::latest()->get();
        $settings = Setting::whereIn('key', ['event_date', 'event_time', 'event_location'])->get()->pluck('value', 'key');
        
        return view('admin.meet-greet.index', compact('slides', 'announcements', 'applications', 'settings'));
    }

    public function updateSettings(Request $request)
    {
        $data = $request->validate([
            'event_date' => 'required|date',
            'event_time' => 'required',
            'event_location' => 'required|string',
        ]);

        // Format to uppercase "M d, Y" e.g. "APR 06, 2026"
        $formattedDate = strtoupper(date('M d, Y', strtotime($data['event_date'])));
        
        // Format to "g:i A" e.g. "2:30 PM"
        $formattedTime = date('g:i A', strtotime($data['event_time']));

        $data['event_date'] = $formattedDate;
        $data['event_time'] = $formattedTime;

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // Sync with Techmeet config.json
        $configPath = public_path('Techmeet/config.json');
        file_put_contents($configPath, json_encode($data, JSON_PRETTY_PRINT));

        return back()->with('success', 'Event settings updated and synced with ticket system.');
    }

    // Manage Slides
    public function storeSlide(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $path = $request->file('image')->store('meet-greet', 'public');

        MeetGreetSlide::create([
            'image' => $path,
            'title' => $request->title,
            'description' => $request->description,
            'order' => $request->order ?? 0,
        ]);

        return back()->with('success', 'Event slide added successfully.');
    }

    public function deleteSlide(MeetGreetSlide $slide)
    {
        if (Storage::disk('public')->exists($slide->image)) {
            Storage::disk('public')->delete($slide->image);
        }
        $slide->delete();
        return back()->with('success', 'Slide removed.');
    }

    // Manage Announcements
    public function storeAnnouncement(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        MeetGreetAnnouncement::create([
            'content' => $request->content,
            'is_active' => true,
        ]);

        return back()->with('success', 'Announcement published.');
    }

    public function toggleAnnouncement(MeetGreetAnnouncement $announcement)
    {
        $announcement->update(['is_active' => !$announcement->is_active]);
        return back()->with('success', 'Announcement status updated.');
    }

    public function deleteAnnouncement(MeetGreetAnnouncement $announcement)
    {
        $announcement->delete();
        return back()->with('success', 'Announcement deleted.');
    }

    // Manage Applications
    public function updateApplicationStatus(Request $request, MeetGreetApplication $application)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,declined'
        ]);

        $application->update(['status' => $request->status]);

        return back()->with('success', 'Application status updated to ' . ucfirst($request->status));
    }

    public function deleteApplication(MeetGreetApplication $application)
    {
        $application->delete();
        return back()->with('success', 'Application record removed.');
    }

    public function exportApplications()
    {
        $applications = MeetGreetApplication::all();
        $fileName = 'meet_greet_applicants_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Full Name', 'Email Address', 'Phone Number', 'Organization', 'Motivation', 'Status', 'Registered At'];

        $callback = function() use($applications, $columns) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM to ensure Excel opens non-ASCII characters correctly
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, $columns);

            foreach ($applications as $app) {
                fputcsv($file, [
                    $app->id,
                    $app->name,
                    $app->email,
                    $app->phone,
                    $app->organization ?? '-',
                    $app->motivation ?? '-',
                    ucfirst($app->status),
                    $app->created_at ? $app->created_at->format('Y-m-d H:i:s') : '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
