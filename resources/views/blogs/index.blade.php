<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Luxenet Blog | Latest Insights</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#060d14">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Luxenet">
    <link rel="apple-touch-icon" href="{{ asset('images/app-icon.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background-color: #060d14; color: white; }
        .blog-container { max-width: 1400px; margin: 0 auto; padding: 120px 5% 60px; }
        .blog-card {
            background: rgba(255, 255, 255, 0.03); 
            backdrop-filter: blur(10px); 
            border: 1px solid rgba(255, 255, 255, 0.1); 
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .blog-card:hover {
            border-color: var(--primary);
            transform: translateY(-5px);
        }
        .blog-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
    </style>
</head>
<body>

    <nav>
        <a href="{{ url('/') }}" class="logo">
            <img src="{{ asset('images/logo-light.png') }}" alt="Luxenet" style="height: 36px;">
        </a>
        <div class="nav-links hide-tablet">
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ route('blogs.index') }}" style="color: var(--primary);">Blog</a>
            <a href="{{ url('/#services') }}">Services</a>
        </div>
        <a href="{{ route('login') }}" class="btn-login">Login</a>
    </nav>

    <div class="blog-container">
        <div class="text-center mb-16">
            <h1 class="text-5xl font-extrabold mb-4">Luxenet <span style="color: var(--primary)">Insights</span></h1>
            <p class="text-gray-400 max-w-2xl mx-auto text-lg">Read our latest articles on networking, software development, and digital innovation.</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($blogs as $blog)
                <a href="{{ route('blogs.show', $blog->slug) }}" class="blog-card block">
                    @if($blog->image)
                        <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="blog-image">
                    @else
                        <div class="blog-image flex items-center justify-center bg-slate-800">
                            <i class="fas fa-newspaper text-5xl text-gray-600"></i>
                        </div>
                    @endif
                    <div class="p-6">
                        <div class="flex justify-between items-center text-xs text-primary font-bold uppercase tracking-widest mb-3">
                            <span>{{ $blog->published_at->format('M d, Y') }}</span>
                            @if($blog->author)
                                <span><i class="fas fa-user mr-1"></i> {{ $blog->author->name }}</span>
                            @endif
                        </div>
                        <h3 class="text-2xl font-bold mb-3 leading-tight text-white">{{ $blog->title }}</h3>
                        <p class="text-gray-400 line-clamp-3 leading-relaxed">
                            {{ strip_tags($blog->content) }}
                        </p>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-20">
                    <i class="fas fa-pen-nib text-6xl text-gray-700 mb-4"></i>
                    <h3 class="text-2xl font-bold text-gray-500">No blogs published yet.</h3>
                    <p class="text-gray-600 mt-2">Check back later for our latest insights.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12 flex justify-center">
            {{ $blogs->links() }}
        </div>
    </div>

    <footer class="py-12 border-t border-white/5 mt-20 text-center">
        <p class="text-gray-600 text-sm">© {{ date('Y') }} Luxenet. All rights reserved.</p>
    </footer>

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function () {
                navigator.serviceWorker.register("{{ asset('service-worker.js') }}")
                    .then(reg => console.log('ServiceWorker registered', reg.scope))
                    .catch(err => console.error('ServiceWorker registration failed:', err));
            });
        }
    </script>
</body>
</html>
