@extends('layouts.admin')

@section('title', 'Manage Blogs')

@section('content')
<div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
    <h4 class="text-default-900 text-lg font-semibold">Blogs Management</h4>

    <div class="md:flex hidden items-center gap-3 text-sm font-semibold">
        <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-default-700">Luxenet</a>
        <i class="ti ti-chevron-right text-lg flex-shrink-0 text-default-500 rtl:rotate-180"></i>
        <a href="#" class="text-sm font-medium text-default-700" aria-current="page">Blogs</a>
    </div>
</div>

<div class="card mb-6">
    <div class="card-header border-b border-default-200 flex justify-between items-center">
        <h4 class="card-title">All Blogs</h4>
        <a href="{{ route('admin.blogs.create') }}" class="btn bg-primary text-white py-2 px-4 rounded-md font-bold text-xs uppercase">Write New Blog</a>
    </div>
    <div class="card-body p-0">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 m-4 rounded text-xs font-bold">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse text-xs">
                <thead class="bg-default-100 border-b border-default-200">
                    <tr>
                        <th class="px-4 py-3 text-left">Title</th>
                        <th class="px-4 py-3 text-left">Author</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Date</th>
                        <th class="px-4 py-3 text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-default-200">
                    @forelse($blogs as $blog)
                    <tr class="hover:bg-default-50 transition-all">
                        <td class="px-4 py-3 font-semibold">{{ $blog->title }}</td>
                        <td class="px-4 py-3">{{ $blog->author ? $blog->author->name : 'Unknown' }}</td>
                        <td class="px-4 py-3">
                            @if($blog->is_published)
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-[10px] font-bold">Published</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-[10px] font-bold">Draft</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $blog->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3 flex gap-2">
                            <a href="{{ route('admin.blogs.edit', $blog) }}" class="text-blue-500 hover:text-blue-700 transition-all"><i class="ti ti-edit size-5"></i> Edit</a>
                            <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this blog?');">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:text-red-700 transition-all"><i class="ti ti-trash size-5"></i> Delete</button>
                            </form>
                            <a href="{{ route('blogs.show', $blog->slug) }}" target="_blank" class="text-gray-500 hover:text-gray-700 transition-all"><i class="ti ti-external-link size-5"></i> View</a>
                            <form action="{{ route('admin.blogs.shareGoogle', $blog) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-green-500 hover:text-green-700 transition-all" title="Share with Google users">
                                    <i class="ti ti-share-2 size-5"></i> Share
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-default-500">No blogs written yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
