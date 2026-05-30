@extends('layouts.admin')

@section('title', 'Product Management')

@section('content')
<div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
    <h4 class="text-default-900 text-lg font-semibold">Shop Products</h4>

    <div class="md:flex hidden items-center gap-3 text-sm font-semibold">
        <a href="#" class="text-sm font-medium text-default-700">Luxenet</a>
        <i class="ti ti-chevron-right text-lg flex-shrink-0 text-default-500 rtl:rotate-180"></i>
        <a href="#" class="text-sm font-medium text-default-700">Shop</a>
        <i class="ti ti-chevron-right text-lg flex-shrink-0 text-default-500 rtl:rotate-180"></i>
        <a href="#" class="text-sm font-medium text-default-700" aria-current="page">Products</a>
    </div>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-200 text-green-800 rounded-md p-4 mb-4 text-xs font-semibold" role="alert">
    {{ session('success') }}
</div>
@endif

<div class="grid lg:grid-cols-3 gap-6">
    <!-- Add Product Form Column -->
    <div class="lg:col-span-1">
        <div class="card">
            <div class="card-header border-b border-default-200">
                <h4 class="card-title text-sm font-bold text-default-800 uppercase tracking-wider">Add New Product</h4>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.shop.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-default-700 mb-1">Product Name</label>
                        <input type="text" name="name" required class="form-input text-xs w-full rounded border border-default-200 py-2 px-3 focus:border-primary focus:ring-1 focus:ring-primary" placeholder="e.g. Cat6 Ethernet Cable 10m">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-default-700 mb-1">Description</label>
                        <textarea name="description" rows="3" class="form-input text-xs w-full rounded border border-default-200 py-2 px-3 focus:border-primary focus:ring-1 focus:ring-primary" placeholder="Product details..."></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-default-700 mb-1">Cost Price (UGX)</label>
                            <input type="number" name="cost_price" required min="0" step="0.01" class="form-input text-xs w-full rounded border border-default-200 py-2 px-3 focus:border-primary focus:ring-1 focus:ring-primary" placeholder="0.00">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-default-700 mb-1">Selling Price (UGX)</label>
                            <input type="number" name="selling_price" required min="0" step="0.01" class="form-input text-xs w-full rounded border border-default-200 py-2 px-3 focus:border-primary focus:ring-1 focus:ring-primary" placeholder="0.00">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-default-700 mb-1">Stock Quantity</label>
                            <input type="number" name="stock" required min="0" class="form-input text-xs w-full rounded border border-default-200 py-2 px-3 focus:border-primary focus:ring-1 focus:ring-primary" placeholder="10">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-default-700 mb-1">Product Image</label>
                            <input type="file" name="image" class="form-input text-xs w-full rounded border border-default-200 py-1.5 focus:border-primary focus:ring-1 focus:ring-primary">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-primary hover:bg-primary/95 text-white text-xs font-bold py-2.5 px-4 rounded-md transition-all uppercase tracking-wider">
                        Add Product
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Product List Column -->
    <div class="lg:col-span-2">
        <div class="card">
            <div class="card-header border-b border-default-200 flex justify-between items-center">
                <h4 class="card-title text-sm font-bold text-default-800 uppercase tracking-wider">Active Catalog</h4>
                <a href="{{ route('admin.shop.orders') }}" class="btn bg-primary/10 text-primary hover:bg-primary hover:text-white py-1 px-3 rounded-md text-xs font-bold">Manage Orders</a>
            </div>
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse text-xs">
                    <thead class="bg-default-100 border-b border-default-200">
                        <tr>
                            <th class="px-4 py-3 text-left">Product</th>
                            <th class="px-4 py-3 text-left">Stock</th>
                            <th class="px-4 py-3 text-left">Cost (UGX)</th>
                            <th class="px-4 py-3 text-left">Selling (UGX)</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-default-200">
                        @forelse($products as $product)
                        <tr class="hover:bg-default-50 transition-all">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="size-10 rounded bg-default-100 overflow-hidden flex-shrink-0 flex items-center justify-center border border-default-200">
                                        @if($product->image_url)
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="object-cover size-full">
                                        @else
                                            <i class="ti ti-package text-lg text-default-400"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-default-900">{{ $product->name }}</div>
                                        <div class="text-[10px] text-default-500 line-clamp-1 max-w-[180px]">{{ $product->description }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                @if($product->stock <= 5)
                                    <span class="text-red-600 font-bold bg-red-50 px-2 py-0.5 rounded text-[10px]">{{ $product->stock }} (Low)</span>
                                @else
                                    <span class="text-green-600 font-semibold bg-green-50 px-2 py-0.5 rounded text-[10px]">{{ $product->stock }} available</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-default-700 font-medium">{{ number_format($product->cost_price, 2) }}</td>
                            <td class="px-4 py-3 text-primary font-bold">{{ number_format($product->selling_price, 2) }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2 items-center">
                                    <!-- Edit Trigger Button (Inlined Form or simple toggle) -->
                                    <button onclick="toggleEditModal({{ $product->id }}, '{{ addslashes($product->name) }}', '{{ addslashes($product->description) }}', {{ $product->cost_price }}, {{ $product->selling_price }}, {{ $product->stock }})" class="size-7 flex items-center justify-center border border-primary text-primary hover:bg-primary hover:text-white rounded transition-all">
                                        <i class="ti ti-edit text-sm"></i>
                                    </button>

                                    <!-- Delete Form -->
                                    <form action="{{ route('admin.shop.delete', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="size-7 flex items-center justify-center border border-red-500 text-red-500 hover:bg-red-500 hover:text-white rounded transition-all">
                                            <i class="ti ti-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-default-500">No products configured in catalog yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Edit Product Modal (Simple responsive backdrop popup) -->
<div id="edit-modal" class="fixed inset-0 z-70 hidden flex items-center justify-center bg-black/50 p-4">
    <div class="bg-white rounded-lg w-full max-w-md shadow-lg border border-default-200 overflow-hidden transform scale-95 transition-all">
        <div class="card-header border-b border-default-200 flex justify-between items-center p-4 bg-default-50">
            <h4 class="card-title text-sm font-bold text-default-800 uppercase tracking-wider">Edit Product</h4>
            <button onclick="closeEditModal()" class="text-default-500 hover:text-default-900"><i class="ti ti-x text-lg"></i></button>
        </div>
        <form id="edit-form" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            @method('PATCH')
            
            <div>
                <label class="block text-xs font-semibold text-default-700 mb-1">Product Name</label>
                <input type="text" name="name" id="edit-name" required class="form-input text-xs w-full rounded border border-default-200 py-2 px-3 focus:border-primary focus:ring-1 focus:ring-primary">
            </div>

            <div>
                <label class="block text-xs font-semibold text-default-700 mb-1">Description</label>
                <textarea name="description" id="edit-description" rows="3" class="form-input text-xs w-full rounded border border-default-200 py-2 px-3 focus:border-primary focus:ring-1 focus:ring-primary"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-default-700 mb-1">Cost Price (UGX)</label>
                    <input type="number" name="cost_price" id="edit-cost-price" required min="0" step="0.01" class="form-input text-xs w-full rounded border border-default-200 py-2 px-3 focus:border-primary focus:ring-1 focus:ring-primary">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-default-700 mb-1">Selling Price (UGX)</label>
                    <input type="number" name="selling_price" id="edit-selling-price" required min="0" step="0.01" class="form-input text-xs w-full rounded border border-default-200 py-2 px-3 focus:border-primary focus:ring-1 focus:ring-primary">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-default-700 mb-1">Stock Quantity</label>
                    <input type="number" name="stock" id="edit-stock" required min="0" class="form-input text-xs w-full rounded border border-default-200 py-2 px-3 focus:border-primary focus:ring-1 focus:ring-primary">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-default-700 mb-1">Replace Image</label>
                    <input type="file" name="image" class="form-input text-xs w-full rounded border border-default-200 py-1.5 focus:border-primary focus:ring-1 focus:ring-primary">
                </div>
            </div>

            <div class="flex justify-end gap-2 pt-4">
                <button type="button" onclick="closeEditModal()" class="btn border border-default-200 text-default-600 hover:bg-default-50 py-1.5 px-4 rounded text-xs font-bold">Cancel</button>
                <button type="submit" class="btn bg-primary hover:bg-primary/95 text-white py-1.5 px-4 rounded text-xs font-bold uppercase">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleEditModal(id, name, description, costPrice, sellingPrice, stock) {
        const form = document.getElementById('edit-form');
        form.action = `/admin/shop/product/${id}`;
        
        document.getElementById('edit-name').value = name;
        document.getElementById('edit-description').value = description;
        document.getElementById('edit-cost-price').value = costPrice;
        document.getElementById('edit-selling-price').value = sellingPrice;
        document.getElementById('edit-stock').value = stock;

        const modal = document.getElementById('edit-modal');
        modal.classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('edit-modal').classList.add('hidden');
    }
</script>
@endsection
