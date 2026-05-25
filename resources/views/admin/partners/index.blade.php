@extends('layouts.admin')

@section('title', 'Partner Management')

@section('content')
<div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
    <h4 class="text-default-900 text-lg font-semibold">Brand & Partner Mgmt</h4>

    <div class="md:flex hidden items-center gap-3 text-sm font-semibold">
        <a href="#" class="text-sm font-medium text-default-700">Luxenet</a>
        <i class="ti ti-chevron-right text-lg flex-shrink-0 text-default-500 rtl:rotate-180"></i>
        <a href="#" class="text-sm font-medium text-default-700" aria-current="page">Partners</a>
    </div>
</div>

<div class="grid xl:grid-cols-3 gap-6">
    <!-- Add Partner Form -->
    <div class="xl:col-span-1">
        <div class="card">
            <div class="card-header border-b border-default-200">
                <h4 class="card-title">Add Partner Logo</h4>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-xs font-bold">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="text-xs font-bold uppercase text-default-500 mb-1 block">Partner Name</label>
                        <input type="text" name="name" required placeholder="e.g. Cisco" class="form-input text-xs">
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase text-default-500 mb-1 block">Logo (SVG or Transparent PNG)</label>
                        <input type="file" name="logo" required class="form-input text-xs">
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase text-default-500 mb-1 block">Display Order</label>
                        <input type="number" name="order" value="0" class="form-input text-xs">
                    </div>
                    <button type="submit" class="w-full btn bg-primary text-white py-2 rounded-md font-bold text-xs uppercase">Upload Partner</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Partner List -->
    <div class="xl:col-span-2">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Active Partners</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse text-xs">
                    <thead class="bg-default-100 border-b border-default-200">
                        <tr>
                            <th class="px-4 py-3 text-left">Logo</th>
                            <th class="px-4 py-3 text-left">Name</th>
                            <th class="px-4 py-3 text-left">Order</th>
                            <th class="px-4 py-3 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-default-200">
                        @forelse($partners as $partner)
                        <tr class="hover:bg-default-50 transition-all">
                            <td class="px-4 py-3">
                                <div class="bg-default-100 p-2 rounded-lg inline-block">
                                    <img src="{{ asset('storage/'.$partner->logo) }}" class="h-8 max-w-[100px] object-contain">
                                </div>
                            </td>
                            <td class="px-4 py-3 font-semibold">{{ $partner->name }}</td>
                            <td class="px-4 py-3">{{ $partner->order }}</td>
                            <td class="px-4 py-3">
                                <form action="{{ route('admin.partners.delete', $partner) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:text-red-700 transition-all"><i class="ti ti-trash size-5"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-default-500">No partner logos uploaded yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
