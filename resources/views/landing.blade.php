<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Luxenet – Pro ISP Systems</title>
    <meta name="description" content="Luxenet provides Internet Service Providers (ISPs) with an advanced billing and network management system that automates operations.">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#060d14">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Luxenet">
    <link rel="apple-touch-icon" href="{{ asset('images/app-icon.png') }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html {
            scroll-behavior: smooth;
        }
        /* Noise Overlay */
        .noise-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 9998;
            opacity: 0.05;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
        }
        /* Progress Bar */
        #scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: var(--primary);
            z-index: 9999;
            transition: width 0.1s ease;
            box-shadow: 0 0 10px var(--primary);
        }
        .partners-section { padding: 60px 5%; background: rgba(255, 255, 255, 0.02); border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color); }
        .partners-grid { display: flex; justify-content: center; align-items: center; gap: 80px; flex-wrap: wrap; opacity: 1; filter: grayscale(0); transition: all 0.5s; }
        .partners-grid:hover { opacity: 1; }
        .partner-logo img { height: 150px; width: auto; max-width: 300px; object-fit: contain; }

        .meet-greet-cta { padding: 80px 5%; }
        .cta-card { 
            background: linear-gradient(135deg, var(--navy), #1a2a3a);
            border-radius: 32px;
            padding: 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 40px;
            border: 1px solid rgba(184, 150, 42, 0.2);
            box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.5);
        }
        .cta-content h3 { font-size: 36px; font-weight: 800; color: white; margin-bottom: 16px; letter-spacing: -0.02em; }
        .cta-content p { color: rgba(255, 255, 255, 0.6); font-size: 18px; max-width: 500px; }
        .btn-cta { 
            background: var(--primary);
            color: white;
            padding: 20px 40px;
            border-radius: 16px;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s;
            box-shadow: 0 10px 30px var(--accent-glow);
        }
        .btn-cta:hover { transform: translateY(-3px); filter: brightness(1.1); box-shadow: 0 15px 40px var(--accent-glow); }
        @media (max-width: 968px) {
            .cta-card { flex-direction: column; text-align: center; padding: 40px; }
            .cta-content h3 { font-size: 28px; }
            .partners-grid { gap: 30px; }
        }

        /* Typewriter Cursor */
        .typewriter-cursor::after {
            content: '|';
            animation: blink 0.8s infinite;
            color: var(--primary);
            margin-left: 2px;
        }
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }

        .hero-title, .hero-desc {
            font-family: 'Space Mono', monospace !important;
        }

        #particle-canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 3;
            pointer-events: none;
        }

        /* Glitch Effect */
        .glitch-badge {
            position: relative;
            display: inline-block;
        }
        .glitch-badge::before, .glitch-badge::after {
            content: attr(data-text);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--accent-glow);
            clip: rect(0, 0, 0, 0);
        }
        .glitch-badge:hover::before {
            left: 2px;
            text-shadow: -2px 0 #ff00c1;
            clip: rect(44px, 450px, 56px, 0);
            animation: glitch-anim 5s infinite linear alternate-reverse;
        }
        .glitch-badge:hover::after {
            left: -2px;
            text-shadow: -2px 0 #00fff9, 2px 2px #ff00c1;
            clip: rect(44px, 450px, 56px, 0);
            animation: glitch-anim2 5s infinite linear alternate-reverse;
        }
        @keyframes glitch-anim {
            0% { clip: rect(31px, 9999px, 94px, 0); }
            20% { clip: rect(62px, 9999px, 42px, 0); }
            40% { clip: rect(16px, 9999px, 78px, 0); }
            60% { clip: rect(43px, 9999px, 11px, 0); }
            80% { clip: rect(54px, 9999px, 86px, 0); }
            100% { clip: rect(9px, 9999px, 32px, 0); }
        }
        @keyframes glitch-anim2 {
            0% { clip: rect(65px, 9999px, 100px, 0); }
            20% { clip: rect(12px, 9999px, 58px, 0); }
            40% { clip: rect(78px, 9999px, 12px, 0); }
            60% { clip: rect(34px, 9999px, 91px, 0); }
            80% { clip: rect(21px, 9999px, 45px, 0); }
            100% { clip: rect(56px, 9999px, 72px, 0); }
        }

        /* Card Spotlight */
        .card {
            position: relative;
        }
        .card::before {
            content: "";
            height: 100%;
            width: 100%;
            position: absolute;
            top: 0px;
            left: 0px;
            background: radial-gradient(800px circle at var(--mouse-x) var(--mouse-y), rgba(184, 150, 42, 0.08), transparent 40%);
            z-index: 1;
            opacity: 0;
            transition: opacity 500ms;
            pointer-events: none;
        }
        .card:hover::before {
            opacity: 1;
        }

        /* Creature Loader */
        #creature {
            position: relative;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }
        #creature div {
            position: absolute;
            width: 1em;
            height: 1em;
            border-radius: 50%;
        }
    </style>
</head>
<body style="overflow: hidden;">
    <div id="scroll-progress"></div>
    <div class="noise-overlay"></div>

    <!-- Premium Anime.js v4 Loader -->
    <div id="lux-loader" class="lux-loader-container" style="position: fixed; inset: 0; background: transparent; z-index: 9999; display: flex; justify-content: center; align-items: center; overflow: hidden;">
        <div class="lux-loader-content" style="position: relative; z-index: 10;">
            <div id="creature"></div>
        </div>
        <div class="loader-curtain curtain-top" style="position: absolute; top: 0; left: 0; width: 100%; height: 51%; background: #060d14; z-index: 5;"></div>
        <div class="loader-curtain curtain-bottom" style="position: absolute; bottom: 0; left: 0; width: 100%; height: 51%; background: #060d14; z-index: 5;"></div>
    </div>

    <nav>
        <a href="/" class="logo">
            <img src="{{ asset('images/logo-dark.png') }}" alt="LuxeNet" class="logo-light-theme">
            <img src="{{ asset('images/logo-light.png') }}" alt="LuxeNet" class="logo-dark-theme">
        </a>
        <div class="nav-links hide-tablet">
            <a href="#services">Services</a>
            <a href="#features">Features</a>
            <a href="#projects">Projects</a>
            <a href="{{ route('meet-greet') }}">Tech Meet & Greet</a>
            <a href="{{ route('shop.catalog') }}" style="color: var(--primary); font-weight: 700;"><i class="fas fa-shopping-bag" style="margin-right: 5px; font-size: 12px;"></i>Shop</a>
            <a href="#pricing">Pricing</a>
            <a href="#contact">Contact</a>
        </div>
        <div style="display: flex; align-items: center; gap: 1rem;">

            @guest
                <a href="{{ route('login') }}" class="btn-login hide-mobile">Login</a>
                <a href="{{ route('register') }}" class="btn-login hide-mobile">Register</a>
            @endguest

            @auth
                <a href="{{ route('admin.dashboard') }}" class="btn-login hide-mobile">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;" class="hide-mobile">
                    @csrf
                    <button type="submit" class="btn-login">Logout</button>
                </form>
            @endauth

            <button class="theme-toggle" id="theme-toggle" title="Toggle Theme">
                <i class="fas fa-moon"></i>
            </button>
            
            <button class="mobile-toggle" id="mobile-toggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobile-menu">
        <a href="#services">Services</a>
        <a href="#features">Features</a>
        <a href="#projects">Projects</a>
        <a href="{{ route('meet-greet') }}">Tech Meet & Greet</a>
        <a href="{{ route('shop.catalog') }}">🛍️ Shop</a>
        <a href="#pricing">Pricing</a>
        <a href="#contact">Contact</a>
        <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 10px 0;">
        @guest
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endguest
        @auth
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        @endauth

    </div>

    @if(session('success'))
    <div style="background: var(--bg-surface); color: var(--text-main); padding: 1rem 5%; text-align: center; border-bottom: 1px solid var(--border-color); margin-top: 64px; font-weight: 500;">
        <i class="fas fa-check-circle" style="color: #10b981; margin-right: 8px;"></i> {{ session('success') }}
    </div>
    @endif

        <header class="hero" style="min-height: 100vh; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; background: transparent;">
        <img src="{{ asset('images/cloud-shaped-heads-collage.jpg') }}" alt="Background" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; filter: blur(4px); z-index: 1;">
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(2, 6, 23, 0.7); z-index: 2;"></div>
        
        <canvas id="particle-canvas"></canvas>

        <div class="reveal" style="position: relative; z-index: 10;">
            <label class="glitch-badge" data-text="Built for Scale" style="color: var(--primary); border: 1px solid var(--primary); padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: 700; margin-bottom: 32px; text-transform: uppercase; letter-spacing: 0.1em; background: var(--accent-glow); cursor: pointer;">Built for Scale</label>
            <h1 class="hero-title typewriter-cursor" style="color: white; margin-top: 24px; min-height: 1.2em;"></h1>
            <p class="hero-desc" style="color: rgba(255,255,255,0.8); max-width: 700px; margin: 24px auto 40px; min-height: 3em;"></p>
            <div class="hero-btns" style="display: flex; gap: 16px; justify-content: center;">
                <a href="{{ route('register') }}" class="btn-primary magnetic-btn">Get Started</a>
                <a href="#services" class="btn-secondary magnetic-btn" style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); color: white;">View Services</a>
            </div>
        </div>
    </header>

    <!-- GSAP Journey Timeline -->
    <div class="gsap-journey-track hide-mobile" style="position: fixed; top: 0; left: 60px; width: 2px; height: 100vh; z-index: 10; pointer-events: none;">
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to bottom, transparent, rgba(184, 150, 42, 0.1) 10%, rgba(184, 150, 42, 0.1) 90%, transparent);"></div>
        <div class="gsap-journey-progress" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: var(--primary); box-shadow: 0 0 15px var(--primary); transform: scaleY(0); transform-origin: top;"></div>
        
        <!-- Glowing Node that travels with the line -->
        <div class="gsap-journey-node" style="position: absolute; top: 0; left: -5px; width: 12px; height: 12px; border-radius: 50%; background: var(--bg-surface); border: 2px solid var(--primary); box-shadow: 0 0 10px var(--primary); transform: translateY(0); opacity: 0;"></div>
    </div>

    <section id="services" style="padding-top: 120px; position: relative; z-index: 20;">
        <div class="section-header reveal">
            <h2 style="font-size: 44px; color: var(--text-main);">Our Core Pillars.</h2>
            <p>Innovative digital solutions, robust networking, and custom software development.</p>
        </div>
        <div class="bento-grid">
            <div class="card bento-item reveal">
                <i class="fas fa-lightbulb" style="color: var(--primary); font-size: 24px; margin-bottom: 24px;"></i>
                <h3 style="font-size: 24px;">Digital Solutions</h3>
                <p>Strategic digital transformation and automation for modern businesses.</p>
            </div>
            
            <div class="card bento-item reveal">
                <i class="fas fa-network-wired" style="color: var(--primary); font-size: 24px; margin-bottom: 24px;"></i>
                <h3>Networking</h3>
                <p>Enterprise-grade infrastructure, ISP management, and security solutions.</p>
            </div>
            
            <div class="card bento-item reveal">
                <i class="fas fa-code" style="color: var(--primary); font-size: 24px; margin-bottom: 24px;"></i>
                <h3>Software Development</h3>
                <p>Custom web applications, POS systems, and specialized business logic.</p>
            </div>
        </div>
    </section>

    {{-- ===== FEATURED HARDWARE SHOP SECTION ===== --}}
    @php
        $featuredProducts = \App\Models\Product::where('stock', '>', 0)->latest()->take(3)->get();
    @endphp
    @if($featuredProducts->count() > 0)
    <section id="shop" style="padding: 100px 5%; background: #060d14; position: relative; z-index: 20; overflow: hidden;">
        {{-- Subtle background glow --}}
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 600px; height: 400px; background: radial-gradient(ellipse, rgba(184,150,42,0.06) 0%, transparent 70%); pointer-events: none;"></div>

        <div style="max-width: 1200px; margin: 0 auto;">
            <div class="section-header reveal" style="margin-bottom: 50px;">
                <label class="glitch-badge" data-text="Hardware & Networking" style="color: var(--primary); border: 1px solid var(--primary); padding: 4px 14px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.12em; background: var(--accent-glow); display: inline-block; margin-bottom: 20px;">Hardware & Networking</label>
                <h2 style="font-size: clamp(2rem, 5vw, 2.8rem); font-weight: 800; letter-spacing: -0.03em; color: var(--text-main);">Luxenet Shop.</h2>
                <p style="color: var(--text-muted); font-size: 17px; max-width: 560px; margin: 12px auto 0;">Premium cables, routers, and networking accessories — directly sourced and tested by our engineers.</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 28px; margin-bottom: 48px;">
                @foreach($featuredProducts as $product)
                <a href="{{ route('shop.show', $product) }}" class="card reveal" style="padding: 0; overflow: hidden; display: flex; flex-direction: column; border-radius: 20px; border: 1px solid rgba(255,255,255,0.06); background: rgba(255,255,255,0.02); text-decoration: none; transition: all 0.35s cubic-bezier(0.4,0,0.2,1);" onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-6px)'; this.style.boxShadow='0 12px 40px -10px rgba(184,150,42,0.15)';" onmouseout="this.style.borderColor='rgba(255,255,255,0.06)'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                    <div style="position: relative; padding-bottom: 65%; background: rgba(255,255,255,0.01); overflow: hidden; border-bottom: 1px solid rgba(255,255,255,0.04);">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="position:absolute; top:0; left:0; width:100%; height:100%; object-fit:cover; transition: transform 0.5s ease;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
                        @else
                            <div style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-network-wired" style="font-size: 3rem; color: rgba(255,255,255,0.08);"></i>
                            </div>
                        @endif
                    </div>
                    <div style="padding: 22px; flex-grow: 1; display: flex; flex-direction: column;">
                        <h3 style="font-size: 1.1rem; font-weight: 700; color: white; margin-bottom: 8px; line-height: 1.3;">{{ $product->name }}</h3>
                        <p style="font-size: 13px; color: rgba(255,255,255,0.45); line-height: 1.5; margin-bottom: 18px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; flex-grow: 1;">{{ $product->description }}</p>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 15px; border-top: 1px solid rgba(255,255,255,0.05);">
                            <span style="font-size: 1.25rem; font-weight: 800; color: var(--primary);">UGX {{ number_format($product->selling_price, 0) }}</span>
                            <span style="font-size: 12px; font-weight: 600; color: var(--primary); display: flex; align-items: center; gap: 5px;">View <i class="fas fa-arrow-right" style="font-size: 10px;"></i></span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="reveal" style="text-align: center;">
                <a href="{{ route('shop.catalog') }}" class="btn-primary magnetic-btn" style="display: inline-flex; align-items: center; gap: 10px;">
                    <i class="fas fa-shopping-bag"></i> View Full Catalog
                </a>
            </div>
        </div>
    </section>
    @endif
    {{-- ===== END SHOP SECTION ===== --}}

    <section id="features" style="background: var(--bg-surface); padding: 120px 5%;">
        <div class="section-header reveal">
            <h2 style="font-size: 44px; color: var(--text-main);">Technical Superiority.</h2>
            <p>Built for the most demanding network environments.</p>
        </div>
        <div class="bento-grid reveal">
            <div class="card bento-item wide">
                <i class="fas fa-mobile-alt" style="color: var(--primary); font-size: 24px; margin-bottom: 24px;"></i>
                <h3>Payments Integration</h3>
                <p>Effortlessly generate invoices and process payments integrated with local mobile money for automated revenue collection.</p>
            </div>
            
            <div class="card bento-item">
                <i class="fas fa-signal" style="color: var(--primary); font-size: 24px; margin-bottom: 24px;"></i>
                <h3>Access Management</h3>
                <p>Control user sessions and bandwidth limits with precision.</p>
            </div>
            
            <div class="card bento-item">
                <i class="fas fa-layer-group" style="color: var(--primary); font-size: 24px; margin-bottom: 24px;"></i>
                <h3>Custom Plans</h3>
                <p>Design flexible service tiers to meet every customer's needs.</p>
            </div>
            
            <div class="card bento-item wide">
                <i class="fas fa-chart-line" style="color: var(--primary); font-size: 24px; margin-bottom: 24px;"></i>
                <h3 style="font-size: 24px;">Advanced Analytics</h3>
                <p>Gain deep insights into traffic patterns, revenue, and customer trends with high-fidelity visualization.</p>
            </div>
            
            <div class="card bento-item full-width">
                <i class="fas fa-bell" style="color: var(--primary); font-size: 24px; margin-bottom: 24px;"></i>
                <h3>Intelligent Alerts</h3>
                <p>Real-time notifications for outages, payments, and system health to keep your operations running smoothly.</p>
            </div>
        </div>
    </section>

    <!-- Notable Projects -->
    <section id="projects" style="padding: 100px 5%; background: var(--bg-surface);">
        <div class="section-header reveal">
            <label class="glitch-badge" data-text="Our Portfolio" style="color: var(--primary); border: 1px solid var(--primary); padding: 4px 14px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.12em; background: var(--accent-glow); display: inline-block; margin-bottom: 20px;">Our Portfolio</label>
            <h2 style="font-size: clamp(2rem, 5vw, 2.8rem); font-weight: 800; letter-spacing: -0.03em; color: var(--text-main);">Notable Projects.</h2>
            <p style="color: var(--text-muted); font-size: 17px; max-width: 560px; margin: 12px auto 0;">Real-world impact across our three core pillars.</p>
        </div>

        <div style="max-width: 1200px; margin: 0 auto;">

            @foreach(['Networking', 'Digital Solutions', 'Software Development'] as $pillar)
                @if(isset($works[$pillar]))
                <div class="reveal" style="margin-bottom: 60px;">
                    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 30px;">
                        <div style="background: var(--primary); width: 4px; height: 32px; border-radius: 4px;"></div>
                        <h3 style="font-size: 24px; font-weight: 700; color: var(--text-main);">{{ $pillar }}</h3>
                    </div>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px;">
                        @foreach($works[$pillar] as $work)
                        <a href="{{ $work->link }}" target="_blank" class="project-card">
                            <div class="project-icon-wrap"><i class="{{ $work->icon ?? 'fas fa-rocket' }}"></i></div>
                            <div style="flex: 1;">
                                <div style="font-size: 16px; font-weight: 700; color: var(--text-main);">{{ $work->title }}</div>
                                <div style="font-size: 12px; color: var(--primary);">{{ $pillar }}</div>
                                <p style="font-size: 14px; color: var(--text-muted); margin-top: 8px;">{{ $work->description }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            @endforeach

        </div>
    </section>

    <!-- Latest Blogs Section -->
    @if(isset($latestBlogs) && $latestBlogs->count() > 0)
    <section id="blogs" style="padding: 100px 5%; background: var(--navy);">
        <div class="section-header reveal">
            <label class="glitch-badge" data-text="Insights" style="color: var(--primary); border: 1px solid var(--primary); padding: 4px 14px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.12em; background: var(--accent-glow); display: inline-block; margin-bottom: 20px;">Insights</label>
            <h2 style="font-size: clamp(2rem, 5vw, 2.8rem); font-weight: 800; letter-spacing: -0.03em; color: white;">Latest News & Updates.</h2>
            <p style="color: rgba(255,255,255,0.7); font-size: 17px; max-width: 560px; margin: 12px auto 0;">Deep dives into network architecture, software solutions, and industry trends.</p>
        </div>

        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 32px;">
                @foreach($latestBlogs as $blog)
                <a href="{{ route('blogs.show', $blog->slug) }}" class="card reveal" style="padding: 0; overflow: hidden; background: rgba(255, 255, 255, 0.02); display: flex; flex-direction: column;">
                    @if($blog->image)
                        <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" style="width: 100%; height: 200px; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 200px; display: flex; align-items: center; justify-content: center; background: #0f172a;">
                            <i class="fas fa-newspaper" style="font-size: 40px; color: rgba(255,255,255,0.1);"></i>
                        </div>
                    @endif
                    <div style="padding: 24px; flex: 1; display: flex; flex-direction: column;">
                        <div style="font-size: 11px; color: var(--primary); font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 12px;">{{ $blog->published_at->format('M d, Y') }}</div>
                        <h3 style="font-size: 20px; font-weight: 700; color: white; margin-bottom: 12px; line-height: 1.3;">{{ $blog->title }}</h3>
                        <p style="font-size: 14px; color: rgba(255,255,255,0.6); margin-bottom: 24px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">{{ strip_tags($blog->content) }}</p>
                        <div style="margin-top: auto; font-size: 13px; font-weight: 600; color: var(--primary);">Read Article <i class="fas fa-arrow-right" style="margin-left: 4px; font-size: 11px;"></i></div>
                    </div>
                </a>
                @endforeach
            </div>
            
            <div class="reveal" style="text-align: center; margin-top: 48px;">
                <a href="{{ route('blogs.index') }}" class="btn-secondary magnetic-btn" style="background: rgba(255,255,255,0.05); color: white; border-color: rgba(255,255,255,0.1);">View All Insights</a>
            </div>
        </div>
    </section>
    @endif

    <!-- Partners Section -->
    @if($partners->count() > 0)
    <section class="partners-section">
        <div style="max-width: 1200px; margin: 0 auto;">
            <h3 style="text-align: center; margin-bottom: 40px; font-size: 11px; text-transform: uppercase; font-weight: 800; letter-spacing: 0.3em; color: var(--primary); opacity: 0.8;">Trusted Network Partners</h3>
            <div class="partners-grid">
                @foreach($partners as $partner)
                <div class="partner-logo" title="{{ $partner->name }}">
                    <img src="{{ asset('storage/'.$partner->logo) }}" alt="{{ $partner->name }}">
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Tech Meet & Greet CTA -->
    <section class="meet-greet-cta">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div class="cta-card reveal">
                <div class="cta-content">
                    <h3>Invite people for Tech Meet & Greet</h3>
                    <p>Connect with the brightest minds in networking and infrastructure. Join our elite community of tech innovators.</p>
                </div>
                <a href="{{ route('meet-greet') }}" class="btn-cta">Explore Event <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>

    <section id="pricing" style="padding: 120px 5%;">
        <div class="section-header reveal">
            <label class="glitch-badge" data-text="Transparent Pricing" style="color: var(--primary); border: 1px solid var(--primary); padding: 4px 14px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.12em; background: var(--accent-glow); display: inline-block; margin-bottom: 20px;">Transparent Pricing</label>
            <h2 style="font-size: 44px; font-weight: 800; color: var(--text-main); letter-spacing: -0.02em;">Tailored Solutions.</h2>
            <p style="color: var(--text-muted); margin-top: 12px;">Choose a plan that fits your business scale and complexity.</p>
        </div>
        <div class="pricing-grid">
            <div class="card price-card reveal">
                <h3>Networking</h3>
                <div class="price">UGX 150k<span>/mo</span></div>
                <p style="color: var(--text-muted); margin-bottom: 24px; font-size: 14px;">Ideal for small ISPs and network hubs needing basic automation.</p>
                <ul style="text-align: left; margin-bottom: 32px; list-style: none; padding: 0; font-size: 14px; color: var(--text-muted);">
                    <li style="margin-bottom: 12px;"><i class="fas fa-check text-primary mr-2"></i> Automated Billing</li>
                    <li style="margin-bottom: 12px;"><i class="fas fa-check text-primary mr-2"></i> Network Monitoring</li>
                    <li><i class="fas fa-check text-primary mr-2"></i> User Access Mgmt</li>
                </ul>
                <a href="{{ route('register') }}" class="btn-secondary magnetic-btn" style="display: block; width: 100%;">Get Started</a>
            </div>
            <div class="card price-card reveal" style="border-color: var(--primary); box-shadow: 0 20px 40px -20px var(--accent-glow);">
                <div style="background: var(--primary); color: white; font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 6px; display: inline-block; margin-bottom: 12px; text-transform: uppercase;">Most Popular</div>
                <h3>Digital Solutions</h3>
                <div class="price">UGX 500k<span>/mo</span></div>
                <p style="color: var(--text-muted); margin-bottom: 24px; font-size: 14px;">Full digital transformation and strategy for growing teams.</p>
                <ul style="text-align: left; margin-bottom: 32px; list-style: none; padding: 0; font-size: 14px; color: var(--text-muted);">
                    <li style="margin-bottom: 12px;"><i class="fas fa-check text-primary mr-2"></i> Full CRM Integration</li>
                    <li style="margin-bottom: 12px;"><i class="fas fa-check text-primary mr-2"></i> Advanced Analytics</li>
                    <li><i class="fas fa-check text-primary mr-2"></i> Custom Dashboards</li>
                </ul>
                <a href="{{ route('register') }}" class="btn-primary magnetic-btn" style="display: block; width: 100%;">Get Started</a>
            </div>
            <div class="card price-card reveal">
                <h3>Software Dev</h3>
                <div class="price">Custom</div>
                <p style="color: var(--text-muted); margin-bottom: 24px; font-size: 14px;">Bespoke software development and enterprise-scale systems.</p>
                <ul style="text-align: left; margin-bottom: 32px; list-style: none; padding: 0; font-size: 14px; color: var(--text-muted);">
                    <li style="margin-bottom: 12px;"><i class="fas fa-check text-primary mr-2"></i> Custom POS Systems</li>
                    <li style="margin-bottom: 12px;"><i class="fas fa-check text-primary mr-2"></i> Dedicated Dev Team</li>
                    <li><i class="fas fa-check text-primary mr-2"></i> Full System Audits</li>
                </ul>
                <a href="#contact" class="btn-secondary magnetic-btn" style="display: block; width: 100%;">Contact Sales</a>
            </div>
        </div>
    </section>

    @php $siteSettings = \App\Models\Setting::pluck('value', 'key'); @endphp
    <section id="contact" style="background: var(--navy); padding: 80px 5%;">
        <div class="section-header reveal">
            <h2 style="color: white;">Contact Us.</h2>
            <p style="color: rgba(255,255,255,0.55);">Get in touch with our team.</p>
        </div>
        <div class="contact-info reveal">
            <div class="contact-item" style="color: rgba(255,255,255,0.8);">
                <i class="fas fa-envelope" style="color: var(--primary);"></i>
                <a href="mailto:{{ $siteSettings['contact_email'] ?? 'info@luxenetworks.co.ke' }}" style="color: rgba(255,255,255,0.88); text-decoration: none;">{{ $siteSettings['contact_email'] ?? 'info@luxenetworks.co.ke' }}</a>
            </div>
            @if(!empty($siteSettings['contact_phone']))
            <div class="contact-item" style="color: rgba(255,255,255,0.8);">
                <i class="fas fa-phone" style="color: var(--primary);"></i>
                <a href="tel:{{ str_replace(' ', '', $siteSettings['contact_phone']) }}" style="color: rgba(255,255,255,0.88); text-decoration: none;">{{ $siteSettings['contact_phone'] }}</a>
            </div>
            @endif
            @if(!empty($siteSettings['contact_address']))
            <div class="contact-item" style="color: rgba(255,255,255,0.8);">
                <i class="fas fa-map-marker-alt" style="color: var(--primary);"></i>
                <span style="color: rgba(255,255,255,0.88);">{{ $siteSettings['contact_address'] }}</span>
            </div>
            @endif
        </div>
    </section>

    <footer style="padding: 60px 10% 36px; border-top: 1px solid rgba(255,255,255,0.08); background: #060d14;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 40px; text-align: left; margin-bottom: 48px;">
            <div style="max-width: 300px;">
                <a href="#" class="logo" style="margin-bottom: 20px; display: block;">
                    <img src="{{ asset('images/logo-light.png') }}" alt="Luxenet" style="height: 40px; width: auto;">
                </a>
                <p style="color: rgba(255,255,255,0.45); font-size: 14px; line-height: 1.7;">{{ $siteSettings['footer_about'] ?? 'Simplifying ISP business by replacing manual spreadsheets with intuitive, high-performance automation.' }}</p>
                <div style="margin-top: 20px; display: flex; gap: 15px;">
                    @if(!empty($siteSettings['social_facebook'])) <a href="{{ $siteSettings['social_facebook'] }}" target="_blank" style="color: rgba(255,255,255,0.5);"><i class="fab fa-facebook"></i></a> @endif
                    @if(!empty($siteSettings['social_twitter'])) <a href="{{ $siteSettings['social_twitter'] }}" target="_blank" style="color: rgba(255,255,255,0.5);"><i class="fab fa-twitter"></i></a> @endif
                    @if(!empty($siteSettings['social_linkedin'])) <a href="{{ $siteSettings['social_linkedin'] }}" target="_blank" style="color: rgba(255,255,255,0.5);"><i class="fab fa-linkedin"></i></a> @endif
                    @if(!empty($siteSettings['social_instagram'])) <a href="{{ $siteSettings['social_instagram'] }}" target="_blank" style="color: rgba(255,255,255,0.5);"><i class="fab fa-instagram"></i></a> @endif
                </div>
            </div>
            <div>
                <h4 style="color: var(--primary); margin-bottom: 16px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700;">Contact</h4>
                <a href="mailto:{{ $siteSettings['contact_email'] ?? 'info@luxenetworks.co.ke' }}" style="font-size: 14px; color: rgba(255,255,255,0.65); text-decoration: none; display: block; margin-bottom: 8px;">{{ $siteSettings['contact_email'] ?? 'info@luxenetworks.co.ke' }}</a>
                @if(!empty($siteSettings['contact_phone']))
                <a href="tel:{{ str_replace(' ', '', $siteSettings['contact_phone']) }}" style="font-size: 14px; color: rgba(255,255,255,0.65); text-decoration: none; display: block; margin-bottom: 8px;">{{ $siteSettings['contact_phone'] }}</a>
                @endif
            </div>
            <div>
                <h4 style="color: var(--primary); margin-bottom: 16px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700;">Quick Links</h4>
                <a href="#services" style="font-size: 14px; color: rgba(255,255,255,0.65); text-decoration: none; display: block; margin-bottom: 8px;">Services</a>
                <a href="#projects" style="font-size: 14px; color: rgba(255,255,255,0.65); text-decoration: none; display: block; margin-bottom: 8px;">Projects</a>
                <a href="{{ route('shop.catalog') }}" style="font-size: 14px; color: rgba(255,255,255,0.65); text-decoration: none; display: block; margin-bottom: 8px;">Shop</a>
                <a href="#pricing" style="font-size: 14px; color: rgba(255,255,255,0.65); text-decoration: none; display: block;">Pricing</a>
            </div>
        </div>
        <div style="padding-top: 28px; border-top: 1px solid rgba(255,255,255,0.07); display: flex; justify-content: space-between; align-items: center; color: rgba(255,255,255,0.3); font-size: 13px; flex-wrap: wrap; gap: 12px;">
            <p>{!! $siteSettings['footer_copyright'] ?? '&copy; ' . date('Y') . ' Luxenetworks. All rights reserved.' !!}</p>
            <p>Developed & Managed by <a href="/" style="color: var(--primary); text-decoration: none; font-weight: 600;">Luxenetworks</a></p>
        </div>
    </footer>

    <!-- Capacity Request Modal -->
    <div id="capacityModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 2000; background: rgba(0,0,0,0.5); backdrop-filter: blur(10px); justify-content: center; align-items: center;">
        <div style="width: 90%; max-width: 500px; position: relative;">
            <span style="position: absolute; top: 1.5rem; right: 1.5rem; font-size: 1.5rem; cursor: pointer; color: var(--text-muted);" onclick="document.getElementById('capacityModal').style.display='none';">&times;</span>
            <h3 style="margin-bottom: 0.5rem; font-size: 24px;">Dedicated Capacity</h3>
            <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 24px;">A mandatory survey fee of 50,000 UGX applies.</p>
            <form action="{{ route('capacity.request') }}" method="POST">
                @csrf
                <div style="margin-bottom: 16px;">
                    <label style="display: block; margin-bottom: 8px; font-size: 14px; color: var(--text-muted);">Full Name</label>
                    <input type="text" name="name" required style="width: 100%;">
                </div>
                <div style="margin-bottom: 16px;">
                    <label style="display: block; margin-bottom: 8px; font-size: 14px; color: var(--text-muted);">Email Address</label>
                    <input type="email" name="email" required style="width: 100%;">
                </div>
                <div style="margin-bottom: 16px;">
                    <label style="display: block; margin-bottom: 8px; font-size: 14px; color: var(--text-muted);">Phone Number</label>
                    <input type="text" name="phone" required style="width: 100%;">
                </div>
                <div style="margin-bottom: 24px;">
                    <label style="display: block; margin-bottom: 8px; font-size: 14px; color: var(--text-muted);">Desired Capacity</label>
                    <select name="capacity" required style="width: 100%;">
                        <option value="500mbps">500 Mbps</option>
                        <option value="1GBps">1 GBps</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary" style="width: 100%; border: none; cursor: pointer;">Submit Request</button>
            </form>
        </div>
    </div>

    <!-- Live Network Monitor -->
    <div id="live-monitor" style="position: fixed; bottom: 24px; right: 24px; z-index: 1000; background: rgba(2, 6, 23, 0.9); backdrop-filter: blur(12px); border: 1px solid var(--primary); border-radius: 16px; padding: 16px; width: 280px; box-shadow: 0 10px 40px rgba(0,0,0,0.4); display: none;" class="reveal hide-mobile">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px solid rgba(192, 126, 0, 0.2); padding-bottom: 8px;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <div style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; animation: pulse 1.5s infinite;"></div>
                <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--primary); letter-spacing: 0.1em;">Network Live</span>
            </div>
            <i class="fas fa-microchip" style="color: var(--primary); font-size: 12px; opacity: 0.6;"></i>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px;">
            <div>
                <label style="display: block; font-size: 10px; color: var(--text-muted); text-transform: uppercase;">Active</label>
                <div id="stat-active" style="font-size: 18px; font-weight: 700; color: white;">0</div>
            </div>
            <div>
                <label style="display: block; font-size: 10px; color: var(--text-muted); text-transform: uppercase;">Today</label>
                <div id="stat-today" style="font-size: 18px; font-weight: 700; color: white;">0</div>
            </div>
        </div>
        <div style="background: rgba(0,0,0,0.3); border-radius: 8px; padding: 10px; font-family: 'Courier New', monospace; font-size: 10px; color: #10b981; height: 60px; overflow: hidden; position: relative;">
            <div id="live-feed" style="position: absolute; bottom: 10px; left: 10px; width: calc(100% - 20px);">
                <div style="opacity: 0.5;">> System initialized...</div>
            </div>
        </div>
    </div>

    <style>
        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.4); opacity: 0.7; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>

    <script>
        // Mock WebSocket / Live Ticker Logic
        const liveMonitor = document.getElementById('live-monitor');
        const liveFeed = document.getElementById('live-feed');
        const statActive = document.getElementById('stat-active');
        const statToday = document.getElementById('stat-today');

        function updateStats() {
            fetch('{{ url('/api/stats') }}')
                .then(res => res.json())
                .then(data => {
                    statActive.innerText = data.active;
                    statToday.innerText = data.today;
                    addFeedItem(`Connection: ${data.label}`);
                })
                .catch(err => console.error('Stats fail', err));
        }

        function addFeedItem(text) {
            const div = document.createElement('div');
            div.innerHTML = `<span style="color: var(--primary)">></span> ${text}`;
            div.style.marginBottom = '4px';
            div.style.animation = 'fadeIn 0.3s ease-out';
            liveFeed.appendChild(div);
            if(liveFeed.children.length > 3) liveFeed.removeChild(liveFeed.firstChild);
        }

        // Show after loader
        setTimeout(() => {
            liveMonitor.style.display = 'block';
            updateStats();
            setInterval(updateStats, 10000); // Pulse every 10s
            
            // Start Typewriter
            const titleEl = document.querySelector('.hero-title');
            const descEl = document.querySelector('.hero-desc');
            const titleText = "Digital Solutions. Networking. Software.";
            const descText = "We empower businesses through strategic digital transformation, enterprise-grade networking, and custom software engineering.";

            function typeWriter(element, text, speed, callback) {
                let i = 0;
                element.innerHTML = '';
                function type() {
                    if (i < text.length) {
                        element.innerHTML += text.charAt(i);
                        i++;
                        setTimeout(type, speed);
                    } else if (callback) {
                        callback();
                    }
                }
                type();
            }

            typeWriter(titleEl, titleText, 50, () => {
                titleEl.classList.remove('typewriter-cursor');
                descEl.classList.add('typewriter-cursor');
                typeWriter(descEl, descText, 20);
            });
        }, 2000);

        // Particle Effect
        const canvas = document.getElementById('particle-canvas');
        const ctx = canvas.getContext('2d');
        let particles = [];
        let mouse = { x: null, y: null, radius: 150 };

        window.addEventListener('mousemove', (e) => {
            mouse.x = e.x;
            mouse.y = e.y;
        });

        class Particle {
            constructor(x, y) {
                this.x = x;
                this.y = y;
                this.baseX = x;
                this.baseY = y;
                this.size = 1.5;
                this.density = (Math.random() * 40) + 5;
                this.color = 'rgba(184, 150, 42, 0.3)';
            }
            draw() {
                ctx.fillStyle = this.color;
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.closePath();
                ctx.fill();
            }
            update() {
                let dx = mouse.x - this.x;
                let dy = mouse.y - this.y;
                let distance = Math.sqrt(dx * dx + dy * dy);
                
                if (distance < mouse.radius) {
                    let forceDirectionX = dx / distance;
                    let forceDirectionY = dy / distance;
                    let maxDistance = mouse.radius;
                    let force = (maxDistance - distance) / maxDistance;
                    let directionX = forceDirectionX * force * this.density;
                    let directionY = forceDirectionY * force * this.density;

                    this.x -= directionX;
                    this.y -= directionY;
                    this.color = '#b8962a';
                    this.size = 2.5;
                } else {
                    if (this.x !== this.baseX) {
                        let dx = this.x - this.baseX;
                        this.x -= dx / 10;
                    }
                    if (this.y !== this.baseY) {
                        let dy = this.y - this.baseY;
                        this.y -= dy / 10;
                    }
                    this.color = 'rgba(184, 150, 42, 0.3)';
                    this.size = 1.5;
                }
            }
        }

        function initParticles() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            particles = [];
            let numberOfParticles = (canvas.width * canvas.height) / 8000;
            for (let i = 0; i < numberOfParticles; i++) {
                let x = Math.random() * canvas.width;
                let y = Math.random() * canvas.height;
                particles.push(new Particle(x, y));
            }
        }

        function animateParticles() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            for (let i = 0; i < particles.length; i++) {
                particles[i].draw();
                particles[i].update();
            }
            requestAnimationFrame(animateParticles);
        }

        initParticles();
        animateParticles();

        window.addEventListener('resize', () => {
            initParticles();
        });

        // Magnetic Buttons
        const magneticBtns = document.querySelectorAll('.magnetic-btn');
        magneticBtns.forEach(btn => {
            btn.addEventListener('mousemove', (e) => {
                const rect = btn.getBoundingClientRect();
                const x = e.clientX - rect.left - rect.width / 2;
                const y = e.clientY - rect.top - rect.height / 2;
                btn.style.transform = `translate(${x * 0.3}px, ${y * 0.5}px) scale(1.05)`;
            });
            btn.addEventListener('mouseleave', () => {
                btn.style.transform = 'translate(0px, 0px) scale(1)';
            });
        });

        // Card Spotlight
        document.querySelectorAll('.card').forEach(card => {
            card.onmousemove = e => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                card.style.setProperty("--mouse-x", `${x}px`);
                card.style.setProperty("--mouse-y", `${y}px`);
            };
        });

        // Scroll Effects
        const mainNav = document.querySelector('nav');
        window.onscroll = () => {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            
            // Progress Bar
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            document.getElementById("scroll-progress").style.width = scrolled + "%";

            // Nav Background
            if (winScroll > 50) {
                mainNav.classList.add('scrolled');
            } else {
                mainNav.classList.remove('scrolled');
            }
        };
    </script>
    
    <script type="module">
        import { animate, createTimeline, createTimer, stagger, utils } from 'https://esm.sh/animejs';

        const creatureEl = document.querySelector('#creature');
        if (creatureEl) {
            const viewport = { w: window.innerWidth * .5, h: window.innerHeight * .5 };
            const cursor = { x: 0, y: 0 };
            const rows = 13;
            const grid = [rows, rows];
            const from = 'center';
            const scaleStagger = stagger([2, 5], { ease: 'inQuad', grid, from });
            const opacityStagger = stagger([1, .1], { grid, from });

            for (let i = 0; i < (rows * rows); i++) {
                creatureEl.appendChild(document.createElement('div'));
            }

            const particuleEls = creatureEl.querySelectorAll('div');

            utils.set(creatureEl, {
                width: rows * 10 + 'em',
                height: rows * 10 + 'em'
            });

            utils.set(particuleEls, {
                x: 0,
                y: 0,
                scale: scaleStagger,
                opacity: opacityStagger,
                background: stagger([80, 20], { grid, from,
                    modifier: v => `hsl(4, 70%, ${v}%)`,
                }),
                boxShadow: stagger([8, 1], { grid, from,
                    modifier: v => `0px 0px ${utils.round(v, 0)}em 0px var(--red)`,
                }),
                zIndex: stagger([rows * rows, 1], { grid, from, modifier: utils.round(0) }),
            });

            const pulse = () => {
                animate(particuleEls, {
                    keyframes: [
                    {
                        scale: 5,
                        opacity: 1,
                        delay: stagger(90, { start: 1650, grid, from }),
                        duration: 150,
                    }, {
                        scale: scaleStagger,
                        opacity: opacityStagger,
                        ease: 'inOutQuad',
                        duration: 600
                    }
                    ],
                });
            }

            const mainLoop = createTimer({
                frameRate: 15, // Animate to the new cursor position every ~66ms (15fps)
                onUpdate: () => {
                    animate(particuleEls, {
                    x: cursor.x,
                    y: cursor.y,
                    delay: stagger(40, { grid, from }),
                    duration: stagger(120, { start: 750, ease: 'inQuad', grid, from }),
                    ease: 'inOut',
                    composition: 'blend', // This allows the animations to overlap nicely
                    });
                }
            });

            const autoMove = createTimeline()
            .add(cursor, {
                x: [-viewport.w * .45, viewport.w * .45],
                modifier: x => x + Math.sin(mainLoop.currentTime * .0007) * viewport.w * .5,
                duration: 3000,
                ease: 'inOutExpo',
                alternate: true,
                loop: true,
                onBegin: pulse,
                onLoop: pulse,
            }, 0)
            .add(cursor, {
                y: [-viewport.h * .45, viewport.h * .45],
                modifier: y => y + Math.cos(mainLoop.currentTime * .00012) * viewport.h * .5,
                duration: 1000,
                ease: 'inOutQuad',
                alternate: true,
                loop: true,
            }, 0);

            const manualMovementTimeout = createTimer({
                duration: 1500,
                onComplete: () => autoMove.play(),
            });

            const followPointer = e => {
                const event = e.type === 'touchmove' ? e.touches[0] : e;
                cursor.x = event.pageX - viewport.w;
                cursor.y = event.pageY - viewport.h;
                autoMove.pause();
                manualMovementTimeout.restart();
            }

            document.addEventListener('mousemove', followPointer);
            document.addEventListener('touchmove', followPointer);
        }
    </script>
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
