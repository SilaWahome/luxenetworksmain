@extends('layouts.admin')

@section('title', 'Portfolio Management')

@section('content')
<div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
    <h4 class="text-default-900 text-lg font-semibold">Portfolio & Works Mgmt</h4>

    <div class="md:flex hidden items-center gap-3 text-sm font-semibold">
        <a href="#" class="text-sm font-medium text-default-700">Luxenet</a>
        <i class="ti ti-chevron-right text-lg flex-shrink-0 text-default-500 rtl:rotate-180"></i>
        <a href="#" class="text-sm font-medium text-default-700" aria-current="page">Works</a>
    </div>
</div>

<div class="grid xl:grid-cols-3 gap-6">
    <!-- Add Work Form -->
    <div class="xl:col-span-1">
        <div class="card">
            <div class="card-header border-b border-default-200">
                <h4 class="card-title">Add New Project</h4>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-xs font-bold">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.works.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="text-xs font-bold uppercase text-default-500 mb-1 block">Project Title</label>
                        <input type="text" name="title" required placeholder="e.g. Luxenet Portal" class="form-input text-xs">
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase text-default-500 mb-1 block">Category</label>
                        <input type="text" name="category" list="categories-list" required placeholder="Select or type a category..." class="form-input text-xs">
                        <datalist id="categories-list">
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}"></option>
                            @endforeach
                            @if($categories->isEmpty())
                                <option value="Networking"></option>
                                <option value="Digital Solutions"></option>
                                <option value="Software Development"></option>
                            @endif
                        </datalist>
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase text-default-500 mb-1 block">Description</label>
                        <textarea name="description" required rows="3" class="form-input text-xs" placeholder="Brief project overview..."></textarea>
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase text-default-500 mb-1 block">Link (URL)</label>
                        <input type="url" name="link" placeholder="https://..." class="form-input text-xs">
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase text-default-500 mb-1 block">Icon Class (FontAwesome)</label>
                        <input type="text" name="icon" placeholder="fas fa-globe" class="form-input text-xs">
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase text-default-500 mb-1 block">Display Order</label>
                        <input type="number" name="order" value="0" class="form-input text-xs">
                    </div>
                    <button type="submit" class="w-full btn bg-primary text-white py-2 rounded-md font-bold text-xs uppercase">Save Project</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Work List -->
    <div class="xl:col-span-2">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Live Portfolio</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse text-xs">
                    <thead class="bg-default-100 border-b border-default-200">
                        <tr>
                            <th class="px-4 py-3 text-left">Title</th>
                            <th class="px-4 py-3 text-left">Category</th>
                            <th class="px-4 py-3 text-left">Link</th>
                            <th class="px-4 py-3 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-default-200">
                        @forelse($works as $work)
                        <tr class="hover:bg-default-50 transition-all">
                            <td class="px-4 py-3">
                                <div class="font-semibold">{{ $work->title }}</div>
                                <div class="text-[10px] text-default-500 truncate max-w-[200px]">{{ $work->description }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="bg-default-100 px-2 py-1 rounded text-[10px] font-bold">{{ $work->category }}</span>
                            </td>
                            <td class="px-4 py-3 text-primary truncate max-w-[150px]">
                                <a href="{{ $work->link }}" target="_blank">{{ $work->link }}</a>
                            </td>
                            <td class="px-4 py-3">
                                <form action="{{ route('admin.works.delete', $work) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:text-red-700 transition-all"><i class="ti ti-trash size-5"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-default-500">No projects added to the portfolio yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
