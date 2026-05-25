<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Download Luxenet App | Web to App Experience</title>
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
        body {
            background-color: #060d14;
            color: white;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow-x: hidden;
            margin: 0;
            padding: 20px;
        }
        .app-card {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.6), 0 0 40px rgba(79, 70, 229, 0.1);
        }
        .instruction-box {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: transform 0.2s, border-color 0.2s;
        }
        .instruction-box:hover {
            border-color: rgba(99, 102, 241, 0.3);
            transform: translateY(-2px);
        }
        .btn-install {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
            transition: all 0.3s;
        }
        .btn-install:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.6);
        }
        .btn-back {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.2s;
        }
        .btn-back:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
    </style>
</head>
<body class="relative">

    <!-- Ambient glow backgrounds -->
    <div class="absolute top-1/4 left-1/4 -translate-x-1/2 -translate-y-1/2 w-[350px] h-[350px] bg-indigo-500/10 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute bottom-1/4 right-1/4 translate-x-1/2 translate-y-1/2 w-[350px] h-[350px] bg-purple-500/10 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="app-card max-w-lg w-full rounded-2xl p-8 md:p-10 text-center relative z-10">
        
        <!-- App Icon -->
        <div class="relative inline-block mb-6">
            <img src="{{ asset('images/app-icon.png') }}" alt="Luxenet App Icon" class="w-24 h-24 rounded-2xl mx-auto shadow-2xl shadow-indigo-500/20 border border-white/10">
            <div class="absolute -bottom-2 -right-2 bg-indigo-600 text-white rounded-full w-8 h-8 flex items-center justify-center border-2 border-[#060d14] text-xs" title="PWA Enabled">
                <i class="fas fa-check"></i>
            </div>
        </div>

        <h1 class="text-3xl font-extrabold tracking-tight text-white mb-2">Luxenet App</h1>
        <p class="text-gray-400 text-sm max-w-md mx-auto mb-8">Access internet tools, latest tech news, and system management offline or online with our lightweight desktop and mobile application.</p>

        <!-- Dynamic Install Button -->
        <div id="install-wrapper" class="hidden mb-8">
            <button id="install-pwa-btn" class="w-full py-4 px-6 btn-install text-white font-bold rounded-xl flex items-center justify-center gap-2">
                <i class="fas fa-download"></i> Install Now
            </button>
            <p class="text-xs text-gray-500 mt-2">Compatible with Android, iOS, Chrome, Edge, and Safari.</p>
        </div>

        <!-- Manual Installation Guides -->
        <div class="space-y-4 text-left">
            <h2 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2"><i class="fas fa-info-circle mr-1"></i> How to Install manually</h2>
            
            <!-- iOS -->
            <div class="instruction-box p-4 rounded-xl flex items-start gap-4">
                <div class="bg-white/5 rounded-lg p-2.5 text-indigo-400">
                    <i class="fab fa-apple text-xl"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white mb-0.5">Safari (iOS / iPhone)</h3>
                    <p class="text-xs text-gray-400">Tap the <strong class="text-white"><i class="fas fa-share-square mx-0.5"></i> Share</strong> button on your browser toolbar, scroll down, and select <strong class="text-white">Add to Home Screen</strong>.</p>
                </div>
            </div>

            <!-- Android -->
            <div class="instruction-box p-4 rounded-xl flex items-start gap-4">
                <div class="bg-white/5 rounded-lg p-2.5 text-indigo-400">
                    <i class="fab fa-android text-xl"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white mb-0.5">Chrome (Android)</h3>
                    <p class="text-xs text-gray-400">Tap the browser menu button <strong class="text-white"><i class="fas fa-ellipsis-v mx-0.5"></i> Settings</strong>, and select <strong class="text-white">Add to Home screen</strong> or <strong class="text-white">Install App</strong>.</p>
                </div>
            </div>

            <!-- Desktop -->
            <div class="instruction-box p-4 rounded-xl flex items-start gap-4">
                <div class="bg-white/5 rounded-lg p-2.5 text-indigo-400">
                    <i class="fas fa-desktop text-xl"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white mb-0.5">Desktop (Chrome / Edge)</h3>
                    <p class="text-xs text-gray-400">Click the <strong class="text-white"><i class="fas fa-laptop-code mx-0.5"></i> Install</strong> icon in the address bar, or open the menu and choose <strong class="text-white">Install Luxenet...</strong></p>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-white/5 flex flex-col sm:flex-row gap-3">
            <a href="{{ route('blogs.index') }}" class="flex-1 py-3 px-6 btn-back text-gray-300 font-bold rounded-xl text-sm flex items-center justify-center gap-2">
                <i class="fas fa-arrow-left"></i> Back to Insights
            </a>
            <a href="{{ url('/') }}" class="flex-1 py-3 px-6 btn-back text-gray-300 font-bold rounded-xl text-sm flex items-center justify-center gap-2">
                <i class="fas fa-home"></i> Go to Homepage
            </a>
        </div>

    </div>

    <!-- PWA Install Handling -->
    <script>
        let deferredPrompt;
        const installWrapper = document.getElementById('install-wrapper');
        const installBtn = document.getElementById('install-pwa-btn');

        window.addEventListener('beforeinstallprompt', (e) => {
            // Prevent default browser install dialog
            e.preventDefault();
            // Stash the event
            deferredPrompt = e;
            // Show the install button wrapper
            installWrapper.classList.remove('hidden');
        });

        installBtn.addEventListener('click', async () => {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;
                console.log(`User responded to PWA install prompt: ${outcome}`);
                deferredPrompt = null;
                installWrapper.classList.add('hidden');
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
    </script>
</body>
</html>
