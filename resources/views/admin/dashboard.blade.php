@extends('layouts.admin')

@section('title', 'System Intelligence')

@section('content')
    <!-- Page Title Start -->
    <div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
        <h4 class="text-default-900 text-lg font-semibold">Dashboard Overview</h4>
    

        <div class="md:flex hidden items-center gap-3 text-sm font-semibold">
            <a href="#" class="text-sm font-medium text-default-700">Luxenet</a>
            <i class="ti ti-chevron-right text-lg flex-shrink-0 text-default-500 rtl:rotate-180"></i>
            <a href="#" class="text-sm font-medium text-default-700" aria-current="page">Intelligence</a>
        </div>
    </div>
    <!-- Page Title End -->

    <div class="grid xl:grid-cols-4 md:grid-cols-2 gap-6 mb-6">
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs tracking-wide font-semibold uppercase text-default-700 mb-3">Amount Owed (KSH)</p>
                        <h4 class="font-semibold text-2xl text-default-700">{{ number_format($invoiceStats['ksh_owed']) }}</h4>
                    </div>
                    <div class="rounded-full flex justify-center items-center size-14 bg-red-100 text-red-600">
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
                        <h4 class="font-semibold text-2xl text-default-700">{{ number_format($invoiceStats['ugx_owed']) }}</h4>
                    </div>
                    <div class="rounded-full flex justify-center items-center size-14 bg-red-100 text-red-600">
                        <i class="ti ti-coins text-2xl transition-all"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs tracking-wide font-semibold uppercase text-default-700 mb-3">Total Income (KSH)</p>
                        <h4 class="font-semibold text-2xl text-default-700">{{ number_format($invoiceStats['ksh_income']) }}</h4>
                    </div>
                    <div class="rounded-full flex justify-center items-center size-14 bg-green-100 text-green-600">
                        <i class="ti ti-receipt-2 text-2xl transition-all"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs tracking-wide font-semibold uppercase text-default-700 mb-3">Total Income (UGX)</p>
                        <h4 class="font-semibold text-2xl text-default-700">{{ number_format($invoiceStats['ugx_income']) }}</h4>
                    </div>
                    <div class="rounded-full flex justify-center items-center size-14 bg-green-100 text-green-600">
                        <i class="ti ti-wallet text-2xl transition-all"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid xl:grid-cols-4 md:grid-cols-2 gap-6 mb-6">
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs tracking-wide font-semibold uppercase text-default-700 mb-3">Total Users</p>
                        <h4 class="font-semibold text-2xl text-default-700">{{ $users->count() }}</h4>
                    </div>
                    <div class="rounded-full flex justify-center items-center size-14 bg-primary/10 text-primary">
                        <i class="ti ti-users text-2xl transition-all"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs tracking-wide font-semibold uppercase text-default-700 mb-3">Capacity Requests</p>
                        <h4 class="font-semibold text-2xl text-default-700">{{ $capacityRequests->count() }}</h4>
                    </div>
                    <div class="rounded-full flex justify-center items-center size-14 bg-secondary/10 text-secondary">
                        <i class="ti ti-file-invoice text-2xl transition-all"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs tracking-wide font-semibold uppercase text-default-700 mb-3">Active Nodes</p>
                        <h4 class="font-semibold text-2xl text-default-700">{{ $users->whereNotNull('password')->count() }}</h4>
                    </div>
                    <div class="rounded-full flex justify-center items-center size-14 bg-success/10 text-success">
                        <i class="ti ti-shield-check text-2xl transition-all"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs tracking-wide font-semibold uppercase text-default-700 mb-3">New Leads</p>
                        <h4 class="font-semibold text-2xl text-default-700">{{ $users->whereNull('password')->count() }}</h4>
                    </div>
                    <div class="rounded-full flex justify-center items-center size-14 bg-warning/10 text-warning">
                        <i class="ti ti-user-plus text-2xl transition-all"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs tracking-wide font-semibold uppercase text-default-700 mb-3">Top Reader</p>
                        <h4 class="font-semibold text-lg text-default-700 line-clamp-1">
                            @if($topReader && $topReader->blogs_read > 0)
                                {{ $topReader->name ?? $topReader->first_name }} ({{ $topReader->blogs_read }})
                            @else
                                None Yet
                            @endif
                        </h4>
                    </div>
                    <div class="rounded-full flex justify-center items-center size-14 bg-purple-100 text-purple-600">
                        <i class="ti ti-star text-2xl transition-all"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Read Blogs Chart -->
    <div class="card mb-6">
        <div class="card-body">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h4 class="text-default-900 text-base font-bold">📊 Most Read Blogs</h4>
                    <p class="text-xs text-default-500 mt-1">Top 10 blog posts by read count</p>
                </div>
                <a href="{{ route('admin.top_blogs.export') }}"
                   class="btn bg-primary text-white py-2 px-4 rounded-md font-bold text-xs uppercase flex items-center gap-2">
                    <i class="ti ti-download"></i> Export CSV
                </a>
            </div>

            @if($topBlogs->count() > 0)
                <canvas id="topBlogsChart" height="120"></canvas>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const ctx = document.getElementById('topBlogsChart').getContext('2d');
                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: @json($topBlogs->pluck('title')),
                                datasets: [{
                                    label: 'Read Count',
                                    data: @json($topBlogs->pluck('read_count')),
                                    backgroundColor: [
                                        'rgba(99,102,241,0.7)',
                                        'rgba(16,185,129,0.7)',
                                        'rgba(245,158,11,0.7)',
                                        'rgba(239,68,68,0.7)',
                                        'rgba(59,130,246,0.7)',
                                        'rgba(168,85,247,0.7)',
                                        'rgba(236,72,153,0.7)',
                                        'rgba(20,184,166,0.7)',
                                        'rgba(249,115,22,0.7)',
                                        'rgba(132,204,22,0.7)'
                                    ],
                                    borderRadius: 6,
                                    borderWidth: 0
                                }]
                            },
                            options: {
                                indexAxis: 'y',
                                responsive: true,
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        callbacks: {
                                            label: ctx => ` ${ctx.parsed.x} reads`
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        beginAtZero: true,
                                        ticks: { precision: 0 },
                                        grid: { color: 'rgba(0,0,0,0.05)' }
                                    },
                                    y: {
                                        grid: { display: false },
                                        ticks: {
                                            font: { size: 12 },
                                            callback: function(val, idx) {
                                                const label = this.getLabelForValue(val);
                                                return label.length > 35 ? label.substring(0, 35) + '…' : label;
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    });
                </script>
            @else
                <div class="text-center py-10 text-default-400">
                    <i class="ti ti-chart-bar text-5xl mb-3 block"></i>
                    <p class="text-sm">No blog reads yet. Share your blogs to start tracking!</p>
                </div>
            @endif
        </div>
    </div>
    <!-- End Top Read Blogs Chart -->

    <!-- Network Registrations Table -->
    <div class="card mb-6" id="users">
        <div class="card-header flex justify-between items-center">
            <h4 class="card-title">Network Registrations</h4>
            <div class="flex items-center gap-2">
                <input type="text" placeholder="Search identities..." class="form-input text-xs py-1 px-3 rounded-md bg-default-100 border-transparent w-48">
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse text-xs">
                <thead class="bg-default-100 border-b border-default-200">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-default-700 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left font-semibold text-default-700 uppercase tracking-wider">First Name</th>
                        <th class="px-4 py-3 text-left font-semibold text-default-700 uppercase tracking-wider">Last Name</th>
                        <th class="px-4 py-3 text-left font-semibold text-default-700 uppercase tracking-wider">Company</th>
                        <th class="px-4 py-3 text-left font-semibold text-default-700 uppercase tracking-wider">Email Address</th>
                        <th class="px-4 py-3 text-left font-semibold text-default-700 uppercase tracking-wider">Phone Number</th>
                        <th class="px-4 py-3 text-left font-semibold text-default-700 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left font-semibold text-default-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-default-200">
                    @forelse($users as $user)
                    <tr class="hover:bg-default-50 transition-all">
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 rounded bg-primary/10 text-primary font-bold font-mono">{{ $user->custom_id }}</span>
                        </td>
                        <td class="px-4 py-4 font-semibold text-default-800">
                            {{ $user->first_name }}
                        </td>
                        <td class="px-4 py-4 font-semibold text-default-800">
                            {{ $user->second_name }}
                        </td>
                        <td class="px-4 py-4 text-default-600">
                            {{ $user->company_name ?? 'Individual' }}
                        </td>
                        <td class="px-4 py-4 text-default-700 font-mono">
                            {{ $user->email }}
                        </td>
                        <td class="px-4 py-4 text-default-600">
                            {{ $user->phone_number }}
                        </td>
                        <td class="px-4 py-4">
                            @if($user->password)
                                <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <span class="size-1.5 rounded-full bg-green-500"></span>
                                    Active Operator
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <span class="size-1.5 rounded-full bg-yellow-500"></span>
                                    Lead
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2">
                                <button class="p-1.5 rounded bg-default-100 text-default-600 hover:bg-primary/10 hover:text-primary transition-all" title="Edit">
                                    <i class="ti ti-pencil size-4"></i>
                                </button>
                                <button class="p-1.5 rounded bg-default-100 text-default-600 hover:bg-primary/10 hover:text-primary transition-all" title="View Details">
                                    <i class="ti ti-eye size-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-10 text-center text-default-500">No registered users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Capacity Requests -->
    <div class="card" id="capacity">
        <div class="card-header">
            <h4 class="card-title text-red-500">High Capacity Requests</h4>
        </div>
        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse">
                <thead class="bg-default-100 border-b border-default-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-default-700 uppercase tracking-wider">Token</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-default-700 uppercase tracking-wider">Requestor</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-default-700 uppercase tracking-wider">Specification</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-default-700 uppercase tracking-wider">Survey Fee</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-default-700 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-default-200">
                    @forelse($capacityRequests as $request)
                    <tr class="hover:bg-default-50 transition-all">
                        <td class="px-4 py-4 text-xs font-bold text-red-400 font-mono">REQ-{{ str_pad($request->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-4 py-4">
                            <div class="font-semibold text-default-800">{{ $request->name }}</div>
                            <div class="text-xs text-default-500">{{ $request->email }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="px-2 py-1 rounded bg-default-100 text-default-600 text-xs font-medium border border-default-200">
                                {{ $request->capacity }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="text-sm font-bold text-green-600">{{ $request->survey_fee }}</span>
                        </td>
                        <td class="px-4 py-4">
                            <button class="p-1.5 rounded bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all">
                                <i class="ti ti-trash size-4"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-default-500">No active capacity requests.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
