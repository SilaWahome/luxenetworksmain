@extends('layouts.admin')

@section('title', 'Shop Orders Management')

@section('content')
<div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
    <h4 class="text-default-900 text-lg font-semibold">Shop Orders</h4>

    <div class="md:flex hidden items-center gap-3 text-sm font-semibold">
        <a href="#" class="text-sm font-medium text-default-700">Luxenet</a>
        <i class="ti ti-chevron-right text-lg flex-shrink-0 text-default-500 rtl:rotate-180"></i>
        <a href="{{ route('admin.shop.index') }}" class="text-sm font-medium text-default-700">Shop</a>
        <i class="ti ti-chevron-right text-lg flex-shrink-0 text-default-500 rtl:rotate-180"></i>
        <a href="#" class="text-sm font-medium text-default-700" aria-current="page">Orders</a>
    </div>
</div>

<div class="card">
    <div class="card-header border-b border-default-200 flex justify-between items-center">
        <h4 class="card-title">All Orders</h4>
        <a href="{{ route('admin.shop.index') }}" class="btn border border-primary text-primary hover:bg-primary hover:text-white py-1 px-3 rounded-md text-xs font-bold">Back to Products</a>
    </div>
    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse text-xs">
            <thead class="bg-default-100 border-b border-default-200">
                <tr>
                    <th class="px-4 py-3 text-left">Order ID</th>
                    <th class="px-4 py-3 text-left">Customer</th>
                    <th class="px-4 py-3 text-left">Amount</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Date</th>
                    <th class="px-4 py-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-default-200">
                @forelse($orders as $order)
                <tr class="hover:bg-default-50 transition-all">
                    <td class="px-4 py-3 font-semibold">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-4 py-3">
                        @if($order->user)
                            <div class="font-bold">{{ $order->user->name }}</div>
                            <div class="text-[10px] text-default-500">{{ $order->user->email }}</div>
                        @else
                            <span class="text-default-400 italic">Guest / Deleted</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 font-bold text-primary">
                        UGX {{ number_format($order->total_amount, 2) }}
                    </td>
                    <td class="px-4 py-3">
                        @if($order->status == 'paid')
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-[10px] font-bold uppercase">Paid</span>
                        @elseif($order->status == 'failed')
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-[10px] font-bold uppercase">Failed</span>
                        @else
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-[10px] font-bold uppercase">Pending</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-[10px] text-default-500">
                        {{ $order->created_at->format('M d, Y H:i') }}
                    </td>
                    <td class="px-4 py-3">
                        <form action="{{ route('admin.shop.orders.update', $order) }}" method="POST" class="flex gap-2 items-center">
                            @csrf @method('PATCH')
                            <select name="status" class="form-input text-xs py-1 px-2 h-7" onchange="this.form.submit()">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="failed" {{ $order->status == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-default-500">No orders placed yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
