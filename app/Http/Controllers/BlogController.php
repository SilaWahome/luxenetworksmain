<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('is_published', true)->latest('published_at')->paginate(12);
        return view('blogs.index', compact('blogs'));
    }

    public function show(Request $request, $slug)
    {
        $blog = Blog::where('slug', $slug)->where('is_published', true)->firstOrFail();
        // Increment the read counter for this blog
        $blog->increment('read_count');

        // Track reader (optional)
        if (auth()->check()) {
            auth()->user()->increment('blogs_read');
        } elseif ($request->has('sub')) {
            $subscriber = \App\Models\Subscriber::find($request->sub);
            if ($subscriber) {
                $subscriber->increment('blogs_read');
            }
        }

        // Related blogs (random 3)
        $relatedBlogs = Blog::where('is_published', true)
            ->where('id', '!=', $blog->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        // Always show the full blog – no auth gating
        return view('blogs.show', compact('blog', 'relatedBlogs'));
    }
}
