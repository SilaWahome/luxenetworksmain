<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscriber;

class SubscriberController extends Controller
{
    public function index()
    {
        $subscribers = Subscriber::orderBy('created_at', 'desc')->get();
        return view('admin.subscribers.index', compact('subscribers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
            'name' => 'nullable|string|max:255'
        ]);

        Subscriber::create($request->only('email', 'name'));

        return back()->with('success', 'Subscriber added successfully.');
    }

    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();
        return back()->with('success', 'Subscriber removed successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $path = $request->file('file')->getRealPath();
        $data = array_map('str_getcsv', file($path));

        // Skip header row if exists by checking if first element is 'email' or similar
        // Let's just blindly import if valid email
        $importedCount = 0;
        foreach ($data as $row) {
            if (isset($row[0])) {
                $email = trim($row[0]);
                $name = isset($row[1]) ? trim($row[1]) : null;

                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    Subscriber::firstOrCreate(
                        ['email' => $email],
                        ['name' => $name]
                    );
                    $importedCount++;
                }
            }
        }

        return back()->with('success', "$importedCount subscribers imported successfully.");
    }
}
