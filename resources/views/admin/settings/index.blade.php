@extends('layouts.admin')

@section('title', 'Site Settings')

@section('content')
    <div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
        <h4 class="text-default-900 text-lg font-semibold">Site Configuration</h4>

        <div class="md:flex hidden items-center gap-3 text-sm font-semibold">
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-default-700">Luxenet</a>
            <i class="ti ti-chevron-right text-lg flex-shrink-0 text-default-500 rtl:rotate-180"></i>
            <a href="#" class="text-sm font-medium text-default-700" aria-current="page">Settings</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Manage Footer & Contact Details</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.settings.store') }}" method="POST">
                @csrf
                
                <h5 class="text-md font-bold text-default-800 mb-4 border-b pb-2">Contact Information</h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="text-sm font-medium text-default-700 mb-1 block">Email Address</label>
                        <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}" class="form-input w-full" placeholder="info@luxenet.com">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-default-700 mb-1 block">Phone Number</label>
                        <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}" class="form-input w-full" placeholder="+256 700 000 000">
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-sm font-medium text-default-700 mb-1 block">Physical Address</label>
                        <textarea name="contact_address" class="form-input w-full" rows="2" placeholder="Digital Intelligence Hub, Kampala">{{ $settings['contact_address'] ?? '' }}</textarea>
                    </div>
                </div>

                <h5 class="text-md font-bold text-default-800 mb-4 border-b pb-2">Footer Content</h5>
                <div class="grid grid-cols-1 gap-4 mb-6">
                    <div>
                        <label class="text-sm font-medium text-default-700 mb-1 block">Footer Description (About Text)</label>
                        <textarea name="footer_about" class="form-input w-full" rows="3" placeholder="Brief description of Luxenet used in the footer.">{{ $settings['footer_about'] ?? '' }}</textarea>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-default-700 mb-1 block">Copyright Text</label>
                        <input type="text" name="footer_copyright" value="{{ $settings['footer_copyright'] ?? '© 2026 Luxenet. All rights reserved.' }}" class="form-input w-full">
                    </div>
                </div>

                <h5 class="text-md font-bold text-default-800 mb-4 border-b pb-2">Social Links</h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="text-sm font-medium text-default-700 mb-1 block">Facebook URL</label>
                        <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}" class="form-input w-full" placeholder="https://facebook.com/...">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-default-700 mb-1 block">Twitter (X) URL</label>
                        <input type="url" name="social_twitter" value="{{ $settings['social_twitter'] ?? '' }}" class="form-input w-full" placeholder="https://twitter.com/...">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-default-700 mb-1 block">LinkedIn URL</label>
                        <input type="url" name="social_linkedin" value="{{ $settings['social_linkedin'] ?? '' }}" class="form-input w-full" placeholder="https://linkedin.com/...">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-default-700 mb-1 block">Instagram URL</label>
                        <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}" class="form-input w-full" placeholder="https://instagram.com/...">
                    </div>
                </div>

                <div class="flex justify-end mt-4">
                    <button type="submit" class="btn bg-primary text-white">Save All Settings</button>
                </div>
            </form>
        </div>
    </div>
@endsection
