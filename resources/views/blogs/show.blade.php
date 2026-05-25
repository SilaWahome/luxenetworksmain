<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $blog->title }} | Luxenet Blog</title>
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
        .article-container { max-width: 900px; margin: 0 auto; padding: 120px 5% 60px; }
        
        .article-header { text-align: center; margin-bottom: 40px; }
        .article-meta { color: var(--primary); font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 20px; }
        .article-title { font-size: 3.5rem; font-weight: 800; line-height: 1.1; margin-bottom: 30px; }
        
        .article-cover { width: 100%; height: auto; max-height: 500px; object-fit: cover; border-radius: 24px; margin-bottom: 40px; border: 1px solid rgba(255, 255, 255, 0.1); }
        
        /* Typography for Rich Text Content from TinyMCE */
        .article-content { font-size: 1.125rem; line-height: 1.8; color: #d1d5db; }
        .article-content h1, .article-content h2, .article-content h3, .article-content h4 { color: white; font-weight: 700; margin-top: 2.5em; margin-bottom: 1em; }
        .article-content h2 { font-size: 2rem; }
        .article-content h3 { font-size: 1.5rem; }
        .article-content p { margin-bottom: 1.5em; }
        .article-content a { color: var(--primary); text-decoration: underline; text-underline-offset: 4px; }
        .article-content ul, .article-content ol { margin-bottom: 1.5em; padding-left: 2em; }
        .article-content ul { list-style-type: disc; }
        .article-content ol { list-style-type: decimal; }
        .article-content li { margin-bottom: 0.5em; }
        .article-content blockquote { border-left: 4px solid var(--primary); padding-left: 1.5em; margin: 2em 0; font-style: italic; color: #9ca3af; background: rgba(255, 255, 255, 0.02); padding: 1.5em; border-radius: 0 12px 12px 0; }
        .article-content img { max-width: 100%; height: auto; border-radius: 12px; margin: 2em auto; display: block; }
        .article-content pre, .article-content code { background: #111827; color: #e5e7eb; padding: 0.2em 0.4em; border-radius: 4px; font-family: monospace; font-size: 0.9em; }
        .article-content pre { padding: 1.5em; overflow-x: auto; margin: 2em 0; }

        .related-card {
            background: rgba(255, 255, 255, 0.03); 
            border: 1px solid rgba(255, 255, 255, 0.1); 
            border-radius: 16px;
            padding: 24px;
            transition: all 0.3s ease;
        }
        .related-card:hover { border-color: var(--primary); transform: translateY(-3px); }
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
        <a href="{{ route('blogs.index') }}" class="btn-login"><i class="fas fa-arrow-left mr-2"></i> All Blogs</a>
    </nav>

    <main class="article-container">
        <article>
            <header class="article-header">
                @php
                    $wordCount = str_word_count(strip_tags($blog->content));
                    $readTime = max(1, ceil($wordCount / 200));
                @endphp
                <div class="article-meta">
                    <i class="fas fa-calendar mr-1"></i> {{ $blog->published_at->format('F d, Y') }} 
                    @if($blog->author)
                        <span class="mx-3 text-gray-600">|</span> 
                        <i class="fas fa-user-edit mr-1"></i> By {{ $blog->author->name }}
                    @endif
                    <span class="mx-3 text-gray-600">|</span> 
                    <i class="fas fa-clock mr-1"></i> {{ $readTime }} min read
                </div>
                <h1 class="article-title">{{ $blog->title }}</h1>
                <p class="text-sm text-gray-400 mt-2"><i class="fas fa-eye mr-1"></i> Views: {{ $blog->read_count }}</p>
            </header>

            @if($blog->image)
                <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="article-cover shadow-2xl">
            @endif

            <div class="article-content">
                {!! $blog->content !!}
            </div>
        </article>

<!-- Premium Subscription Modal & App Promotion -->
<style>
    .glass-modal-container {
        background: rgba(10, 20, 30, 0.8);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 30px rgba(79, 70, 229, 0.2);
    }
    .interest-tag-label input:checked + span {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        border-color: #6366f1;
        color: white;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }
    .pulse-btn {
        background: linear-gradient(135deg, #b8962a, #d4af37);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 15px rgba(184, 150, 42, 0.2);
    }
    .pulse-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(184, 150, 42, 0.4);
    }
    .app-cta-btn {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s;
    }
    .app-cta-btn:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.2);
        color: #fff;
    }
    #subscribe-close {
        transition: transform 0.2s;
    }
    #subscribe-close:hover {
        transform: scale(1.1) rotate(90deg);
    }
</style>

<div id="subscribe-modal" class="fixed inset-0 flex items-center justify-center bg-black/70 backdrop-blur-sm z-50 hidden" aria-hidden="true">
    <div class="glass-modal-container rounded-2xl p-8 max-w-md w-full relative border text-center">
        <!-- Close Button -->
        <button id="subscribe-close" class="absolute top-4 right-4 text-gray-400 hover:text-white text-xl font-bold focus:outline-none" aria-label="Close modal">✕</button>
        
        <!-- Premium Icon -->
        <div class="mx-auto w-16 h-16 bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-500 rounded-full flex items-center justify-center mb-6 shadow-lg shadow-indigo-500/20">
            <i class="fas fa-paper-plane text-2xl text-white animate-pulse"></i>
        </div>

        <h2 class="text-3xl font-extrabold text-white mb-2 tracking-tight">Join Luxenet Pulse</h2>
        <p class="text-gray-300 text-sm mb-6">Get premium updates on technology, networking, and gaming delivered straight to your inbox.</p>
        
        <form id="subscribe-form" class="space-y-5">
            <!-- Interest Selector Tags -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-3 text-left">Select Interests</label>
                <div class="flex flex-wrap gap-2 justify-start">
                    <label class="interest-tag-label cursor-pointer">
                        <input type="checkbox" name="interests[]" value="technology" checked class="sr-only">
                        <span class="px-4 py-2 rounded-full border border-white/10 bg-white/5 text-gray-300 text-xs font-semibold transition-all duration-200 block">
                            <i class="fas fa-laptop-code mr-1"></i> Technology
                        </span>
                    </label>
                    <label class="interest-tag-label cursor-pointer">
                        <input type="checkbox" name="interests[]" value="networking" checked class="sr-only">
                        <span class="px-4 py-2 rounded-full border border-white/10 bg-white/5 text-gray-300 text-xs font-semibold transition-all duration-200 block">
                            <i class="fas fa-network-wired mr-1"></i> Networking
                        </span>
                    </label>
                    <label class="interest-tag-label cursor-pointer">
                        <input type="checkbox" name="interests[]" value="gaming" checked class="sr-only">
                        <span class="px-4 py-2 rounded-full border border-white/10 bg-white/5 text-gray-300 text-xs font-semibold transition-all duration-200 block">
                            <i class="fas fa-gamepad mr-1"></i> Gaming
                        </span>
                    </label>
                </div>
            </div>

            <!-- Email Input -->
            <div class="relative">
                <input type="email" name="email" required placeholder="Enter your email address"
                       class="w-full px-4 py-3 pl-11 rounded-xl bg-white/5 text-white placeholder-gray-500 border border-white/10 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"/>
                <div class="absolute left-4 top-3.5 text-gray-500">
                    <i class="fas fa-envelope"></i>
                </div>
            </div>

            <!-- Buttons -->
            <div class="space-y-3 pt-2">
                <button type="submit" class="w-full py-3 px-6 pulse-btn text-white font-bold rounded-xl text-sm uppercase tracking-wider">
                    Subscribe Now <i class="fas fa-arrow-right ml-1"></i>
                </button>
                
                <!-- Install App Button -->
                <button type="button" id="pwa-install-btn" class="w-full py-3 px-6 app-cta-btn text-gray-300 font-bold rounded-xl text-sm flex items-center justify-center gap-2">
                    <i class="fas fa-download text-indigo-400"></i> Install App for Offline Access
                </button>
            </div>

            <p id="subscribe-msg" class="mt-3 text-sm hidden font-semibold"></p>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('subscribe-modal');
    const closeBtn = document.getElementById('subscribe-close');
    const form = document.getElementById('subscribe-form');
    const msg = document.getElementById('subscribe-msg');
    const pwaInstallBtn = document.getElementById('pwa-install-btn');

    // Show modal on page load
    modal.classList.remove('hidden');

    closeBtn.addEventListener('click', () => modal.classList.add('hidden'));

    // Handle form submission
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        
        // Disable subscribe button during submit
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner animate-spin"></i> Subscribing...';

        const formData = new FormData(form);
        fetch('{{ route('subscribers.store') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                msg.textContent = data.message;
                msg.className = 'mt-3 text-green-400';
                form.reset();
                setTimeout(() => modal.classList.add('hidden'), 2500);
            } else {
                msg.textContent = data.errors && data.errors.email ? data.errors.email[0] : (data.message || 'Failed to subscribe.');
                msg.className = 'mt-3 text-red-400';
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Subscribe Now <i class="fas fa-arrow-right ml-1"></i>';
            }
            msg.classList.remove('hidden');
        })
        .catch(() => {
            msg.textContent = 'Network error. Please try again.';
            msg.className = 'mt-3 text-red-400';
            msg.classList.remove('hidden');
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Subscribe Now <i class="fas fa-arrow-right ml-1"></i>';
        });
    });

    // PWA Install Prompt handling
    let deferredPrompt;
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        // PWA is installable, highlight the install button
        pwaInstallBtn.classList.remove('app-cta-btn');
        pwaInstallBtn.classList.add('bg-indigo-600', 'hover:bg-indigo-700', 'text-white');
    });

    pwaInstallBtn.addEventListener('click', async () => {
        if (deferredPrompt) {
            deferredPrompt.prompt();
            const { outcome } = await deferredPrompt.userChoice;
            console.log(`User response to PWA install: ${outcome}`);
            deferredPrompt = null;
        } else {
            // Fallback to custom app instructions / PWA support page
            window.location.href = "{{ url('/download-app') }}";
        }
    });

    // Register Service Worker
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function () {
            navigator.serviceWorker.register("{{ asset('service-worker.js') }}")
                .then(reg => console.log('ServiceWorker registered', reg.scope))
                .catch(err => console.error('ServiceWorker registration failed:', err));
        });
    }
});
</script>
            <div class="mt-24 pt-12 border-t border-white/10">
                <h3 class="text-2xl font-bold mb-8 flex items-center"><i class="fas fa-book-open text-primary mr-3"></i> Related Insights</h3>
                <div class="grid md:grid-cols-3 gap-6">
                    @foreach($relatedBlogs as $related)
                        <a href="{{ route('blogs.show', $related->slug) }}" class="related-card block">
                            <div class="text-[10px] text-primary font-bold uppercase tracking-widest mb-2">{{ $related->published_at->format('M d, Y') }}</div>
                            <h4 class="text-lg font-bold text-white mb-2 leading-tight">{{ $related->title }}</h4>
                            <p class="text-sm text-gray-400 line-clamp-2">{{ strip_tags($related->content) }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        
    </main>

    <footer class="py-12 border-t border-white/5 mt-10 text-center">
        <p class="text-gray-600 text-sm">© {{ date('Y') }} Luxenet. All rights reserved.</p>
    </footer>

</body>
</html>
