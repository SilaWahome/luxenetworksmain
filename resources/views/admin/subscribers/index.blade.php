@extends('layouts.admin')

@section('title', 'Manage Mailing List')

@section('content')
<div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
    <h4 class="text-default-900 text-lg font-semibold">Mailing List</h4>

    <div class="md:flex hidden items-center gap-3 text-sm font-semibold">
        <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-default-700">Luxenet</a>
        <i class="ti ti-chevron-right text-lg flex-shrink-0 text-default-500 rtl:rotate-180"></i>
        <a href="#" class="text-sm font-medium text-default-700" aria-current="page">Subscribers</a>
    </div>
</div>

@if($errors->any())
    <div class="bg-red-100 text-red-700 p-3 mb-4 rounded text-xs font-bold">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 mb-4 rounded text-xs font-bold">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <!-- Add Single Subscriber -->
    <div class="card">
        <div class="card-header border-b border-default-200">
            <h4 class="card-title">Add Subscriber Manually</h4>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.subscribers.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-medium text-default-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" name="email" class="form-input w-full border border-gray-300 rounded p-2 text-sm" required placeholder="john@example.com">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-default-700 mb-1">Name (Optional)</label>
                    <input type="text" name="name" class="form-input w-full border border-gray-300 rounded p-2 text-sm" placeholder="John Doe">
                </div>
                <button type="submit" class="btn bg-primary text-white py-2 px-4 rounded-md font-bold text-xs uppercase w-full">Add Subscriber</button>
            </form>
        </div>
    </div>

    <!-- Import CSV -->
    <div class="card">
        <div class="card-header border-b border-default-200">
            <h4 class="card-title">Import Subscribers (CSV/TXT)</h4>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.subscribers.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <p class="text-xs text-gray-500 mb-3">Upload a CSV file containing emails. The system expects the first column to be the email address, and optionally the second column to be the name.</p>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-default-700 mb-1">Select File <span class="text-red-500">*</span></label>
                    <input type="file" name="file" accept=".csv, .txt" class="form-input w-full border border-gray-300 rounded p-2 text-sm" required>
                </div>
                <button type="submit" class="btn bg-green-600 text-white py-2 px-4 rounded-md font-bold text-xs uppercase w-full">Import from File</button>
            </form>
        </div>
    </div>
</div>

<div class="card mb-6">
    <div class="card-header border-b border-default-200 flex justify-between items-center">
        <h4 class="card-title">All Subscribers ({{ $subscribers->count() }})</h4>
    </div>
    <div class="card-body p-0">
        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse text-xs">
                <thead class="bg-default-100 border-b border-default-200">
                    <tr>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-left">Added On</th>
                        <th class="px-4 py-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-default-200">
                    @forelse($subscribers as $sub)
                    <tr class="hover:bg-default-50 transition-all">
                        <td class="px-4 py-3 font-semibold">{{ $sub->email }}</td>
                        <td class="px-4 py-3">{{ $sub->name ?: 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $sub->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3 text-right">
                            <form action="{{ route('admin.subscribers.destroy', $sub) }}" method="POST" onsubmit="return confirm('Remove this subscriber?');">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:text-red-700 transition-all"><i class="ti ti-trash size-5"></i> Remove</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-default-500">No subscribers found. Add or import above.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
