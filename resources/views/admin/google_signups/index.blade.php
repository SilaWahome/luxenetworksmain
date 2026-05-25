@extends('layouts.admin')

@section('title', 'Google Sign‑Ups')

@section('content')
<div class="card">
    <div class="card-header flex justify-between items-center">
        <h4 class="card-title">Google Sign‑Ups</h4>
    </div>
    <div class="card-body">
        @if($googleUsers->isEmpty())
            <p class="text-center text-gray-500">No users have signed up via Google yet.</p>
        @else
            <table class="min-w-full border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Name</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-left">Signed Up At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($googleUsers as $user)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $user->custom_id }}</td>
                            <td class="px-4 py-2">{{ $user->first_name }} {{ $user->second_name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">{{ $user->google_signup_at ? $user->google_signup_at->format('Y-m-d H:i') : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
