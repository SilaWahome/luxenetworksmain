@extends('layouts.admin')

@section('title', 'Write New Blog')

@section('content')
<div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
    <h4 class="text-default-900 text-lg font-semibold">Write New Blog</h4>

    <div class="md:flex hidden items-center gap-3 text-sm font-semibold">
        <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-default-700">Luxenet</a>
        <i class="ti ti-chevron-right text-lg flex-shrink-0 text-default-500 rtl:rotate-180"></i>
        <a href="{{ route('admin.blogs.index') }}" class="text-sm font-medium text-default-700">Blogs</a>
        <i class="ti ti-chevron-right text-lg flex-shrink-0 text-default-500 rtl:rotate-180"></i>
        <a href="#" class="text-sm font-medium text-default-700" aria-current="page">Write</a>
    </div>
</div>

<div class="card mb-6">
    <div class="card-body">
        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-xs font-bold">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            
            <div>
                <label class="text-xs font-bold uppercase text-default-500 mb-1 block">Blog Title</label>
                <input type="text" name="title" required value="{{ old('title') }}" placeholder="Enter the blog title..." class="form-input text-sm w-full border border-gray-300 rounded p-2">
            </div>

            <div>
                <label class="text-xs font-bold uppercase text-default-500 mb-1 block">Cover Image</label>
                <input type="file" name="image" accept="image/*" class="form-input text-sm w-full border border-gray-300 rounded p-2">
            </div>
            <div>
                <label class="text-xs font-bold uppercase text-default-500 mb-1 block">Category</label>
                <input type="text" name="category" required value="{{ old('category') }}" placeholder="Enter blog category..." class="form-input text-sm w-full border border-gray-300 rounded p-2" />
            </div>

            <div>
                <label class="text-xs font-bold uppercase text-default-500 mb-1 block">Content</label>
                <!-- TinyMCE Editor will replace this textarea -->
                <textarea id="blog-content" name="content" class="form-input w-full">{{ old('content') }}</textarea>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}>
                <label for="is_published" class="text-sm font-bold text-default-700">Publish Immediately</label>
            </div>

            <div class="pt-4 border-t border-default-200">
                <button type="submit" class="btn bg-primary text-white py-2 px-6 rounded-md font-bold text-sm uppercase">Save Blog</button>
                <a href="{{ route('admin.blogs.index') }}" class="btn bg-gray-200 text-gray-700 py-2 px-6 rounded-md font-bold text-sm uppercase ml-2">Cancel</a>
            </div>
        </form>
    </div>
</div>

<!-- TinyMCE Script -->
<script src="https://cdn.tiny.cloud/1/hwpbxi1dfmz7b7fuu7nrdpyi9taqpzzidyl3adn412k2h09l/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#blog-content',
        plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
        toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
        menubar: 'file edit view insert format tools table help',
        height: 600,
        image_advtab: true,
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
    });
</script>
@endsection
