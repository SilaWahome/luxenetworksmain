@extends('layouts.admin')

@section('title', 'Meet & Greet Management')

@section('content')
<div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
    <h4 class="text-default-900 text-lg font-semibold">Tech Meet & Greet Mgmt</h4>

    <div class="md:flex hidden items-center gap-3 text-sm font-semibold">
        <a href="#" class="text-sm font-medium text-default-700">Luxenet</a>
        <i class="ti ti-chevron-right text-lg flex-shrink-0 text-default-500 rtl:rotate-180"></i>
        <a href="#" class="text-sm font-medium text-default-700" aria-current="page">Meet & Greet</a>
    </div>
</div>

<div class="grid xl:grid-cols-3 gap-6">
    <!-- Management Forms -->
    <div class="xl:col-span-1 space-y-6">
        <!-- Global Event Settings -->
        <div class="card border-primary/30">
            <div class="card-header border-b border-default-200 bg-primary/5">
                <h4 class="card-title text-primary"><i class="ti ti-settings mr-2"></i> Event Ticket Settings</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.meet-greet.settings.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="text-xs font-bold uppercase text-default-500 mb-1 block">Event Date</label>
                        <input type="date" name="event_date" value="{{ isset($settings['event_date']) && strtotime($settings['event_date']) ? date('Y-m-d', strtotime($settings['event_date'])) : '' }}" required class="form-input text-xs">
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase text-default-500 mb-1 block">Event Time</label>
                        <input type="time" name="event_time" value="{{ isset($settings['event_time']) && strtotime($settings['event_time']) ? date('H:i', strtotime($settings['event_time'])) : '' }}" required class="form-input text-xs">
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase text-default-500 mb-1 block">Location</label>
                        <input type="text" name="event_location" value="{{ $settings['event_location'] ?? 'SILVERBACK LOUNGE' }}" placeholder="e.g. SILVERBACK LOUNGE" required class="form-input text-xs">
                    </div>
                    <button type="submit" class="w-full btn bg-primary text-white py-2 rounded-md font-bold text-xs uppercase shadow-lg shadow-primary/20">Sync Settings</button>
                </form>
            </div>
        </div>

        <!-- Add Slide -->
        <div class="card">
            <div class="card-header border-b border-default-200">
                <h4 class="card-title"><i class="ti ti-photo-plus mr-2"></i> Add Event Slide</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.meet-greet.slides.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="text-xs font-bold uppercase text-default-500 mb-1 block">Slide Image</label>
                        <input type="file" name="image" required class="form-input text-xs">
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase text-default-500 mb-1 block">Title</label>
                        <input type="text" name="title" placeholder="Upcoming Meetup..." class="form-input text-xs">
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase text-default-500 mb-1 block">Description</label>
                        <textarea name="description" rows="3" class="form-input text-xs"></textarea>
                    </div>
                    <button type="submit" class="w-full btn bg-default-800 text-white py-2 rounded-md font-bold text-xs uppercase">Upload Slide</button>
                </form>
            </div>
        </div>

        <!-- Add Announcement -->
        <div class="card">
            <div class="card-header border-b border-default-200">
                <h4 class="card-title"><i class="ti ti-megaphone mr-2"></i> Post Announcement</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.meet-greet.announcements.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="text-xs font-bold uppercase text-default-500 mb-1 block">Announcement Content</label>
                        <textarea name="content" rows="4" required class="form-input text-xs" placeholder="What's happening?"></textarea>
                    </div>
                    <button type="submit" class="w-full btn bg-secondary text-white py-2 rounded-md font-bold text-xs uppercase">Post Announcement</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Data Tables -->
    <div class="xl:col-span-2 space-y-6">
        <!-- Slides Table -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Active Slides</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse text-xs">
                    <thead class="bg-default-100 border-b border-default-200">
                        <tr>
                            <th class="px-4 py-2 text-left">Preview</th>
                            <th class="px-4 py-2 text-left">Title</th>
                            <th class="px-4 py-2 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-default-200">
                        @foreach($slides as $slide)
                        <tr class="hover:bg-default-50 transition-all">
                            <td class="px-4 py-2">
                                <img src="{{ asset('storage/'.$slide->image) }}" class="h-10 w-16 object-cover rounded border border-default-200">
                            </td>
                            <td class="px-4 py-2 font-medium">{{ $slide->title }}</td>
                            <td class="px-4 py-2">
                                <form action="{{ route('admin.meet-greet.slides.delete', $slide) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:text-red-700"><i class="ti ti-trash size-5"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Announcements Table -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Announcements</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse text-xs">
                    <thead class="bg-default-100 border-b border-default-200">
                        <tr>
                            <th class="px-4 py-2 text-left">Content</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-default-200">
                        @foreach($announcements as $announcement)
                        <tr class="hover:bg-default-50 transition-all">
                            <td class="px-4 py-2 truncate max-w-xs">{{ $announcement->content }}</td>
                            <td class="px-4 py-2">
                                <form action="{{ route('admin.meet-greet.announcements.toggle', $announcement) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-2 py-1 rounded text-[10px] font-bold uppercase {{ $announcement->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $announcement->is_active ? 'Visible' : 'Hidden' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-4 py-2">
                                <form action="{{ route('admin.meet-greet.announcements.delete', $announcement) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:text-red-700"><i class="ti ti-trash size-5"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Statistics Dashboard -->
        @php
            $uniqueEvents = $applications->pluck('event')->unique()->filter()->values();
        @endphp
        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <!-- Pie Chart Card -->
            <div class="card border-primary/20 shadow-primary/5">
                <div class="card-header bg-primary/5 flex justify-between items-center border-b border-default-200">
                    <h4 class="card-title text-primary font-bold"><i class="ti ti-chart-pie mr-2"></i> Application Distribution</h4>
                    <select id="eventInstanceFilter" class="form-input text-[10px] py-1 px-2.5 rounded border border-primary/20 bg-white text-default-800 focus:ring-primary focus:border-primary font-bold max-w-[200px]">
                        <option value="all">All Event Instances</option>
                        @foreach($uniqueEvents as $index => $evt)
                            <option value="{{ $evt }}">Instance {{ $index + 1 }}: {{ Str::limit($evt, 25) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="card-body flex justify-center items-center h-64 p-4">
                    <canvas id="applicantsPieChart" class="max-h-full"></canvas>
                </div>
            </div>

            <!-- Grouped Event Breakdown Card -->
            <div class="card border-primary/20 shadow-primary/5">
                <div class="card-header bg-primary/5 flex justify-between items-center border-b border-default-200">
                    <h4 class="card-title text-primary font-bold"><i class="ti ti-chart-bar mr-2"></i> Applicants by Event</h4>
                </div>
                <div class="card-body overflow-y-auto h-64 p-4 space-y-4">
                    @forelse($uniqueEvents as $index => $evtName)
                        @php
                            $evtCount = $applications->where('event', $evtName)->count();
                            $evtApproved = $applications->where('event', $evtName)->where('status', 'approved')->count();
                            $totalCount = max($applications->count(), 1);
                            $percentage = round(($evtCount / $totalCount) * 100);
                            
                            $colorThemes = [
                                0 => 'bg-primary/5 text-primary border-primary/10',
                                1 => 'bg-green-500/5 text-green-600 border-green-500/10',
                                2 => 'bg-blue-500/5 text-blue-600 border-blue-500/10',
                                3 => 'bg-purple-500/5 text-purple-600 border-purple-500/10',
                                4 => 'bg-yellow-500/5 text-yellow-600 border-yellow-500/10'
                            ];
                            $theme = $colorThemes[$index % 5];
                            $styleParts = explode(' ', $theme);
                        @endphp
                        <div class="p-3 rounded border {{ $styleParts[2] }} {{ $styleParts[0] }}">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-bold text-xs uppercase">{{ $evtName }}</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $styleParts[0] }} {{ $styleParts[1] }} border {{ $styleParts[2] }}">{{ $evtCount }} Applications</span>
                            </div>
                            <div class="w-full bg-default-100 rounded-full h-2 mb-1">
                                <div class="bg-primary h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            <div class="flex justify-between items-center text-[10px] text-default-500">
                                <span>{{ $percentage }}% of total</span>
                                <span class="font-semibold text-green-600">{{ $evtApproved }} Approved</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 text-default-400 italic">No applications received yet.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Applications Table -->
        <div class="card border-primary/20 shadow-primary/5">
            <div class="card-header bg-primary/5 flex justify-between items-center">
                <h4 class="card-title text-primary font-bold"><i class="ti ti-user-check mr-2"></i> Event Applications</h4>
                <div class="flex items-center gap-2">
                    <span class="badge bg-primary text-white">{{ $applications->where('status', 'pending')->count() }} Pending</span>
                    <a href="{{ route('admin.meet-greet.applications.export') }}" class="btn btn-sm bg-green-600 text-white hover:bg-green-700 px-3 py-1 rounded text-xs flex items-center gap-1 font-bold shadow shadow-green-600/20">
                        <i class="ti ti-file-spreadsheet"></i> Export to Excel
                    </a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse text-xs">
                    <thead class="bg-default-100 border-b border-default-200 text-default-600">
                        <tr>
                            <th class="px-4 py-3 text-left">Full Name</th>
                            <th class="px-4 py-3 text-left">Email Address</th>
                            <th class="px-4 py-3 text-left">Phone Number</th>
                            <th class="px-4 py-3 text-left">Assigned Event</th>
                            <th class="px-4 py-3 text-left">Organization</th>
                            <th class="px-4 py-3 text-left">Motivation</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-default-200">
                        @foreach($applications as $app)
                        <tr class="hover:bg-primary/5 transition-all">
                            <td class="px-4 py-3 font-bold text-default-900">
                                {{ $app->name }}
                            </td>
                            <td class="px-4 py-3 text-default-700 font-mono">
                                {{ $app->email }}
                            </td>
                            <td class="px-4 py-3 text-default-700 font-mono">
                                {{ $app->phone ?? '-' }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded text-[10px] bg-default-100 border border-default-200 text-default-600 font-medium">
                                    {{ $app->event ?? 'Event 1 (Kampala Tech Meetup)' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-default-600">
                                {{ $app->organization ?? '-' }}
                            </td>
                            <td class="px-4 py-3 max-w-xs truncate italic text-default-500" title="{{ $app->motivation }}">
                                "{{ $app->motivation }}"
                            </td>
                            <td class="px-4 py-3">
                                @if($app->status === 'approved')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Approved</span>
                                @elseif($app->status === 'declined')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Declined</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Pending</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    @if($app->status !== 'approved')
                                    <form action="{{ route('admin.meet-greet.applications.status', $app) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="bg-green-100 text-green-700 hover:bg-green-200 px-2 py-1 rounded text-[10px] font-bold uppercase transition-all flex items-center gap-1" title="Approve">
                                            <i class="ti ti-check"></i>
                                        </button>
                                    </form>
                                    @endif
                                    
                                    @if($app->status !== 'declined')
                                    <form action="{{ route('admin.meet-greet.applications.status', $app) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="declined">
                                        <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 px-2 py-1 rounded text-[10px] font-bold uppercase transition-all flex items-center gap-1" title="Decline">
                                            <i class="ti ti-x"></i>
                                        </button>
                                    </form>
                                    @endif

                                    <form action="{{ route('admin.meet-greet.applications.delete', $app) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-default-400 hover:text-red-600 transition-all" title="Delete"><i class="ti ti-trash size-5"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const applications = @json($applications);
        
        const ctx = document.getElementById('applicantsPieChart').getContext('2d');
        
        function getChartData(instance) {
            let filtered = applications;
            if (instance !== 'all') {
                filtered = applications.filter(app => app.event === instance);
            }

            const approved = filtered.filter(app => app.status === 'approved').length;
            const pending = filtered.filter(app => app.status === 'pending' || !app.status).length;
            const declined = filtered.filter(app => app.status === 'declined').length;

            return [approved, pending, declined];
        }

        const chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Approved', 'Pending', 'Declined/Rejected'],
                datasets: [{
                    data: getChartData('all'),
                    backgroundColor: [
                        '#10b981', // green for approved
                        '#f59e0b', // yellow for pending
                        '#ef4444'  // red for declined
                    ],
                    borderWidth: 1,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#475569',
                            font: {
                                size: 11,
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        });

        document.getElementById('eventInstanceFilter').addEventListener('change', function(e) {
            const selectedInstance = e.target.value;
            chart.data.datasets[0].data = getChartData(selectedInstance);
            chart.update();
        });
    });
</script>
@endpush
@endsection
