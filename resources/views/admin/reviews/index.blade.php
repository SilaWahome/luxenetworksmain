@extends('layouts.admin')

@section('title', 'Review Management')

@section('content')
<div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
    <h4 class="text-default-900 text-lg font-semibold">Customer Reviews</h4>

    <div class="md:flex hidden items-center gap-3 text-sm font-semibold">
        <a href="#" class="text-sm font-medium text-default-700">Luxenet</a>
        <i class="ti ti-chevron-right text-lg flex-shrink-0 text-default-500 rtl:rotate-180"></i>
        <a href="#" class="text-sm font-medium text-default-700">Management</a>
        <i class="ti ti-chevron-right text-lg flex-shrink-0 text-default-500 rtl:rotate-180"></i>
        <a href="#" class="text-sm font-medium text-default-700" aria-current="page">Reviews</a>
    </div>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-200 text-green-800 rounded-md p-4 mb-4 text-xs font-semibold" role="alert">
    {{ session('success') }}
</div>
@endif

<div class="grid lg:grid-cols-3 gap-6">
    <!-- Add Review Form Column -->
    <div class="lg:col-span-1">
        <div class="card">
            <div class="card-header border-b border-default-200">
                <h4 class="card-title text-sm font-bold text-default-800 uppercase tracking-wider">Add New Review</h4>
            </div>
            <div class="p-6">
                <form action="{{ route('reviews.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-default-700 mb-1">Author Name</label>
                        <input type="text" name="author_name" required class="form-input text-xs w-full rounded border border-default-200 py-2 px-3 focus:border-primary focus:ring-1 focus:ring-primary" placeholder="e.g. Judith Black">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-default-700 mb-1">Author Role / Designation</label>
                        <input type="text" name="author_role" class="form-input text-xs w-full rounded border border-default-200 py-2 px-3 focus:border-primary focus:ring-1 focus:ring-primary" placeholder="e.g. CEO of Workcation">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-default-700 mb-1">Avatar / Image URL (optional)</label>
                        <input type="url" name="author_image" class="form-input text-xs w-full rounded border border-default-200 py-2 px-3 focus:border-primary focus:ring-1 focus:ring-primary" placeholder="https://images.unsplash.com/...">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-default-700 mb-1">Review Content</label>
                        <textarea name="content" rows="4" required class="form-input text-xs w-full rounded border border-default-200 py-2 px-3 focus:border-primary focus:ring-1 focus:ring-primary" placeholder="Type review here..."></textarea>
                    </div>

                    <button type="submit" class="w-full bg-primary hover:bg-primary/95 text-white text-xs font-bold py-2.5 px-4 rounded-md transition-all uppercase tracking-wider">
                        Add Review
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Review List Column -->
    <div class="lg:col-span-2">
        <div class="card">
            <div class="card-header border-b border-default-200 flex justify-between items-center">
                <h4 class="card-title text-sm font-bold text-default-800 uppercase tracking-wider">Review Pipeline</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse text-xs">
                    <thead class="bg-default-100 border-b border-default-200">
                        <tr>
                            <th class="px-4 py-3 text-left">Author</th>
                            <th class="px-4 py-3 text-left">Content</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-default-200">
                        @forelse($reviews as $review)
                        <tr class="hover:bg-default-50 transition-all">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="size-10 rounded bg-default-100 overflow-hidden flex-shrink-0 flex items-center justify-center border border-default-200">
                                        <img src="{{ $review->author_image ?? 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80' }}" alt="" class="object-cover size-full" style="width: 40px; height: 40px;">
                                    </div>
                                    <div>
                                        <div class="font-bold text-default-900">{{ $review->author_name }}</div>
                                        <div class="text-[10px] text-default-500">{{ $review->author_role ?? 'Customer' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-default-700 max-w-[280px] break-words">{{ $review->content }}</p>
                            </td>
                            <td class="px-4 py-3">
                                @if($review->approved)
                                    <span class="text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded text-[10px]">Approved</span>
                                @else
                                    <span class="text-amber-600 font-bold bg-amber-50 px-2 py-0.5 rounded text-[10px]">Pending Approval</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2 items-center">
                                    @if(!$review->approved)
                                        <!-- Approve Form -->
                                        <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-green-600 text-white hover:bg-green-700 px-3 py-1 rounded text-[10px] font-bold transition-all">
                                                Approve
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Delete Form -->
                                    <form action="{{ route('admin.reviews.delete', $review) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white hover:bg-red-600 px-3 py-1 rounded text-[10px] font-bold transition-all">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-default-500">No reviews found. Submit one on the left!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
