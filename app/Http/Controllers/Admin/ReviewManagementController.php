<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewManagementController extends Controller
{
    public function index()
    {
        $reviews = Review::latest()->get();
        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve(Review $review)
    {
        $review->update(['approved' => true]);
        return back()->with('success', 'Review approved successfully!');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Review deleted successfully!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'author_name' => 'required|string|max:255',
            'author_role' => 'nullable|string|max:255',
            'content' => 'required|string',
            'author_image' => 'nullable|url',
        ]);

        Review::create([
            'author_name' => $request->author_name,
            'author_role' => $request->author_role,
            'content' => $request->content,
            'author_image' => $request->author_image,
            'approved' => false,
        ]);

        return back()->with('success', 'Thank you! Your review has been submitted for approval.');
    }
}
