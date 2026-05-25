@extends('layouts.admin')

@section('title', 'Invoice Management')

@section('content')
    <div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
        <h4 class="text-default-900 text-lg font-semibold">Financial Intelligence</h4>

        <div class="md:flex hidden items-center gap-3 text-sm font-semibold">
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-default-700">Luxenet</a>
            <i class="ti ti-chevron-right text-lg flex-shrink-0 text-default-500 rtl:rotate-180"></i>
            <a href="#" class="text-sm font-medium text-default-700" aria-current="page">Invoices</a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid xl:grid-cols-4 md:grid-cols-2 gap-6 mb-6">
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs tracking-wide font-semibold uppercase text-default-700 mb-3">Amount Owed (KSH)</p>
                        <h4 class="font-semibold text-2xl text-default-700">{{ number_format($stats['ksh_owed']) }}</h4>
                    </div>
                    <div class="rounded-full flex justify-center items-center size-14 bg-primary/10 text-primary">
                        <i class="ti ti-cash text-2xl transition-all"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs tracking-wide font-semibold uppercase text-default-700 mb-3">Amount Owed (UGX)</p>
                        <h4 class="font-semibold text-2xl text-default-700">{{ number_format($stats['ugx_owed']) }}</h4>
                    </div>
                    <div class="rounded-full flex justify-center items-center size-14 bg-secondary/10 text-secondary">
                        <i class="ti ti-coins text-2xl transition-all"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs tracking-wide font-semibold uppercase text-default-700 mb-3">Income (KSH)</p>
                        <h4 class="font-semibold text-2xl text-default-700">{{ number_format($stats['ksh_income']) }}</h4>
                    </div>
                    <div class="rounded-full flex justify-center items-center size-14 bg-success/10 text-success">
                        <i class="ti ti-receipt-2 text-2xl transition-all"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs tracking-wide font-semibold uppercase text-default-700 mb-3">Income (UGX)</p>
                        <h4 class="font-semibold text-2xl text-default-700">{{ number_format($stats['ugx_income']) }}</h4>
                    </div>
                    <div class="rounded-full flex justify-center items-center size-14 bg-info/10 text-info">
                        <i class="ti ti-wallet text-2xl transition-all"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Generate Invoice Form -->
        <div class="lg:col-span-1">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Generate New Invoice</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.invoices.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="text-sm font-medium text-default-700 mb-1 block">Company Name</label>
                                <input type="text" name="company_name" class="form-input w-full" required>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-default-700 mb-1 block">Person Name (Optional)</label>
                                <input type="text" name="person_name" class="form-input w-full">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-medium text-default-700 mb-1 block">Invoice Date</label>
                                    <input type="date" name="date" class="form-input w-full" required>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-default-700 mb-1 block">Due Date</label>
                                    <input type="date" name="due_date" class="form-input w-full" required>
                                </div>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-default-700 mb-1 block">Currency</label>
                                <select name="currency" class="form-input w-full" required>
                                    <option value="KSH">KSH (Kenya Shilling)</option>
                                    <option value="UGX">UGX (Uganda Shilling)</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-default-700 mb-1 block">Client Logo (Optional)</label>
                                <input type="file" name="client_logo" class="form-input w-full">
                            </div>

                            <div class="mt-4">
                                <h5 class="text-sm font-bold text-default-700 mb-2">Invoice Items</h5>
                                <div id="items-container">
                                    <div class="item-row grid grid-cols-12 gap-2 mb-2">
                                        <div class="col-span-6">
                                            <input type="text" name="items[0][description]" placeholder="Description" class="form-input text-xs w-full" required>
                                        </div>
                                        <div class="col-span-2">
                                            <input type="number" name="items[0][quantity]" placeholder="Qty" class="form-input text-xs w-full" required>
                                        </div>
                                        <div class="col-span-4">
                                            <input type="number" name="items[0][unit_price]" placeholder="Price" class="form-input text-xs w-full" required>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" onclick="addItem()" class="mt-2 text-xs font-semibold text-primary hover:underline">+ Add Another Item</button>
                            </div>

                            <button type="submit" class="btn bg-primary text-white w-full mt-4">Generate & Save Invoice</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Invoices List -->
        <div class="lg:col-span-2">
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <h4 class="card-title">Recent Invoices</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="table-auto w-full border-collapse">
                        <thead class="bg-default-100 border-b border-default-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-default-700 uppercase tracking-wider">Invoice #</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-default-700 uppercase tracking-wider">Client</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-default-700 uppercase tracking-wider">Amount</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-default-700 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-default-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-default-200">
                            @forelse($invoices as $invoice)
                            <tr class="hover:bg-default-50 transition-all">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 rounded bg-primary/10 text-primary text-xs font-bold font-mono">{{ $invoice->invoice_number }}</span>
                                    <div class="text-[10px] text-default-500 mt-1">Due: {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</div>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-2">
                                        @if($invoice->client_logo)
                                            <img src="{{ Storage::url($invoice->client_logo) }}" class="size-8 rounded object-contain bg-white border border-default-200">
                                        @else
                                            <div class="size-8 rounded bg-default-200 flex items-center justify-center text-default-500 font-bold text-xs">
                                                {{ substr($invoice->company_name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-semibold text-default-800 text-sm">{{ $invoice->company_name }}</div>
                                            @if($invoice->person_name)
                                                <div class="text-xs text-default-500">{{ $invoice->person_name }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="text-sm font-bold text-default-700">{{ number_format($invoice->total_amount) }} {{ $invoice->currency }}</div>
                                    <div class="text-[10px] text-green-600">Paid: {{ number_format($invoice->paid_amount) }}</div>
                                </td>
                                <td class="px-4 py-4">
                                    @if($invoice->status == 'paid')
                                        <span class="inline-flex items-center gap-1 py-0.5 px-2 rounded-full text-[10px] font-medium bg-green-100 text-green-800">
                                            <span class="size-1 rounded-full bg-green-500"></span>
                                            Fully Paid
                                        </span>
                                    @elseif($invoice->status == 'partially_paid')
                                        <span class="inline-flex items-center gap-1 py-0.5 px-2 rounded-full text-[10px] font-medium bg-yellow-100 text-yellow-800">
                                            <span class="size-1 rounded-full bg-yellow-500"></span>
                                            Partially Paid
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 py-0.5 px-2 rounded-full text-[10px] font-medium bg-red-100 text-red-800">
                                            <span class="size-1 rounded-full bg-red-500"></span>
                                            Unpaid
                                        </span>
                                    @endif

                                    @if($invoice->is_cleared)
                                        <span class="ml-1 text-[10px] text-blue-600 font-bold uppercase">CLEARED</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('admin.invoices.download', $invoice) }}" class="p-1.5 rounded bg-default-100 text-default-600 hover:bg-primary/10 hover:text-primary transition-all" title="Download PDF">
                                            <i class="ti ti-download size-4"></i>
                                        </a>
                                        <button onclick="openPaymentModal({{ $invoice->id }}, '{{ $invoice->invoice_number }}', {{ $invoice->total_amount - $invoice->paid_amount }})" class="p-1.5 rounded bg-default-100 text-default-600 hover:bg-success/10 hover:text-success transition-all" title="Record Payment">
                                            <i class="ti ti-coin size-4"></i>
                                        </button>
                                        @if(!$invoice->is_cleared && $invoice->status == 'paid')
                                            <form action="{{ route('admin.invoices.clear', $invoice) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="p-1.5 rounded bg-blue-50 text-blue-500 hover:bg-blue-500 hover:text-white transition-all" title="Clear to Income">
                                                    <i class="ti ti-circle-check size-4"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-default-500">No invoices generated yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div id="payment-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
            <div class="p-6">
                <h3 class="text-lg font-bold text-default-800 mb-4">Record Payment for <span id="modal-invoice-num"></span></h3>
                <form id="payment-form" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="text-sm font-medium text-default-700 mb-1 block">Amount Received</label>
                        <input type="number" name="paid_amount" id="modal-balance" step="0.01" class="form-input w-full" required>
                        <p class="text-[10px] text-default-500 mt-1">Remaining balance will be calculated automatically.</p>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closePaymentModal()" class="btn bg-default-100 text-default-700">Cancel</button>
                        <button type="submit" class="btn bg-success text-white">Record Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let itemIndex = 1;
        function addItem() {
            const container = document.getElementById('items-container');
            const row = document.createElement('div');
            row.className = 'item-row grid grid-cols-12 gap-2 mb-2';
            row.innerHTML = `
                <div class="col-span-6">
                    <input type="text" name="items[${itemIndex}][description]" placeholder="Description" class="form-input text-xs w-full" required>
                </div>
                <div class="col-span-2">
                    <input type="number" name="items[${itemIndex}][quantity]" placeholder="Qty" class="form-input text-xs w-full" required>
                </div>
                <div class="col-span-4">
                    <input type="number" name="items[${itemIndex}][unit_price]" placeholder="Price" class="form-input text-xs w-full" required>
                </div>
            `;
            container.appendChild(row);
            itemIndex++;
        }

        function openPaymentModal(id, num, balance) {
            document.getElementById('modal-invoice-num').innerText = num;
            document.getElementById('modal-balance').value = balance;
            let url = "{{ route('admin.invoices.payment', ':id') }}";
            document.getElementById('payment-form').action = url.replace(':id', id);
            document.getElementById('payment-modal').classList.remove('hidden');
        }

        function closePaymentModal() {
            document.getElementById('payment-modal').classList.add('hidden');
        }
    </script>
@endsection
