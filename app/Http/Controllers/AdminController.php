<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\CapacityRequest;
use App\Models\Partner;
use App\Models\Work;
use Illuminate\Support\Facades\Storage;
use App\Models\Blog;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        $capacityRequests = CapacityRequest::orderBy('id', 'desc')->get();
        
        $topBlogs = Blog::orderBy('read_count', 'desc')->take(10)->get();
        
        $invoiceStats = [
            'ksh_owed' => \App\Models\Invoice::where('currency', 'KSH')->where('is_cleared', false)->sum('total_amount') - \App\Models\Invoice::where('currency', 'KSH')->where('is_cleared', false)->sum('paid_amount'),
            'ugx_owed' => \App\Models\Invoice::where('currency', 'UGX')->where('is_cleared', false)->sum('total_amount') - \App\Models\Invoice::where('currency', 'UGX')->where('is_cleared', false)->sum('paid_amount'),
            'ksh_income' => \App\Models\Invoice::where('currency', 'KSH')->sum('paid_amount'),
            'ugx_income' => \App\Models\Invoice::where('currency', 'UGX')->sum('paid_amount'),
        ];

        $topUserReader = User::orderBy('blogs_read', 'desc')->first();
        $topSubscriberReader = \App\Models\Subscriber::orderBy('blogs_read', 'desc')->first();

        $topReader = null;
        if ($topUserReader && $topSubscriberReader) {
            $topReader = $topUserReader->blogs_read >= $topSubscriberReader->blogs_read ? $topUserReader : $topSubscriberReader;
        } else {
            $topReader = $topUserReader ?? $topSubscriberReader;
        }

        return view('admin.dashboard', compact('users', 'capacityRequests', 'invoiceStats', 'topBlogs', 'topReader'));
    }

    public function exportTopBlogs()
    {
        $topBlogs = \App\Models\Blog::orderBy('read_count', 'desc')->take(10)->get();
        $columns = ['Title', 'Read Count'];
        $callback = function() use ($topBlogs, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($topBlogs as $blog) {
                fputcsv($file, [$blog->title, $blog->read_count]);
            }
            fclose($file);
        };
        return response()->streamDownload($callback, 'top_blogs.csv', ['Content-Type' => 'text/csv']);
    }

    public function managePartners()
    {
        $partners = Partner::orderBy('order')->get();
        return view('admin.partners.index', compact('partners'));
    }

    public function storePartner(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:10240',
            'order' => 'nullable|integer',
        ]);

        $path = $request->file('logo')->store('partners', 'public');

        Partner::create([
            'name' => $request->name,
            'logo' => $path,
            'order' => $request->order ?? 0,
        ]);

        return back()->with('success', 'Partner logo added successfully.');
    }

    public function deletePartner(Partner $partner)
    {
        if (Storage::disk('public')->exists($partner->logo)) {
            Storage::disk('public')->delete($partner->logo);
        }
        $partner->delete();
        return back()->with('success', 'Partner removed.');
    }

    public function manageWorks()
    {
        $works = Work::orderBy('category')->orderBy('order')->get();
        $categories = Work::select('category')->distinct()->pluck('category');
        return view('admin.works.index', compact('works', 'categories'));
    }

    public function storeWork(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
            'link' => 'nullable|url',
            'icon' => 'nullable|string',
            'image' => 'nullable|image|max:10240',
            'order' => 'nullable|integer',
        ]);

        $imagePath = $request->hasFile('image') ? $request->file('image')->store('works', 'public') : null;

        Work::create([
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'link' => $request->link,
            'icon' => $request->icon,
            'image' => $imagePath,
            'order' => $request->order ?? 0,
        ]);

        return back()->with('success', 'Work project added successfully.');
    }

    public function deleteWork(Work $work)
    {
        if ($work->image && Storage::disk('public')->exists($work->image)) {
            Storage::disk('public')->delete($work->image);
        }
        $work->delete();
        return back()->with('success', 'Project removed.');
    }
}
