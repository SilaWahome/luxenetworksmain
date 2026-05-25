<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CapacityRequest;

class CapacityRequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'capacity' => 'required|string|max:50',
        ]);

        CapacityRequest::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'capacity' => $request->capacity,
            'survey_fee' => '50,000 UGX',
        ]);

        return redirect()->back()->with('success', 'Your capacity request has been submitted successfully. Our team will contact you shortly to arrange the survey.');
    }
}
