<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hardware Shop | Luxenet</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background-color: #060d14; color: white; font-family: 'Inter', sans-serif; }
        .shop-container { max-width: 1200px; margin: 0 auto; padding: 120px 5% 60px; }
        .section-header { text-align: center; margin-bottom: 50px; }
        .section-title { font-size: 3rem; font-weight: 800; line-height: 1.1; margin-bottom: 15px; }
        .section-subtitle { color: #b8962a; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; }
        
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
        }
        
        .product-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-col: column;
            flex-direction: column;
            height: 100%;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            border-color: #b8962a;
            box-shadow: 0 10px 30px -10px rgba(184, 150, 42, 0.15);
        }
        
        .product-img-wrapper {
            position: relative;
            padding-bottom: 80%;
            background: rgba(255, 255, 255, 0.01);
            overflow: hidden;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .product-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .product-card:hover .product-img {
            transform: scale(1.05);
        }
        
        .product-info {
            padding: 24px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        
        .product-name {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: white;
            line-height: 1.3;
        }
        
        .product-desc {
            color: #9ca3af;
            font-size: 0.875rem;
            line-height: 1.5;
            margin-bottom: 20px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex-grow: 1;
        }
        
        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 15px;
            border-t: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .product-price {
            font-size: 1.35rem;
            font-weight: 800;
            color: #b8962a;
        }
        
        .btn-add-cart {
            background: linear-gradient(135deg, #b8962a, #d4af37);
            color: #060d14;
            font-weight: 700;
            font-size: 0.875rem;
            padding: 10px 18px;
            border-radius: 12px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
        }
        
        .btn-add-cart:hover {
            opacity: 0.95;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(184, 150, 42, 0.3);
        }
        
        .cart-badge-nav {
            position: relative;
            display: inline-flex;
            align-items: center;
        }
        
        .cart-count {
            position: absolute;
            top: -8px;
            right: -12px;
            background: #b8962a;
            color: #060d14;
            font-size: 10px;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 10px;
            min-width: 16px;
            text-align: center;
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
            <a href="{{ route('blogs.index') }}">Blog</a>
            <a href="{{ route('shop.catalog') }}" style="color: var(--primary);">Shop</a>
        </div>
        
        <div class="flex items-center gap-6">
            <a href="{{ route('shop.cart') }}" class="cart-badge-nav text-white hover:text-primary transition-all text-lg mr-4">
                <i class="fas fa-shopping-cart"></i>
                @php $cartCount = count(session()->get('cart', [])); @endphp
                @if($cartCount > 0)
                    <span class="cart-count">{{ $cartCount }}</span>
                @endif
            </a>
            <a href="{{ route('login') }}" class="btn-login"><i class="fas fa-user mr-2"></i> Partner Portal</a>
        </div>
    </nav>

    <main class="shop-container">
        @if(session('success'))
            <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399; padding: 15px; border-radius: 12px; margin-bottom: 30px; font-weight: 600; text-align: center;">
                {{ session('success') }}
            </div>
        @endif

        <header class="section-header">
            <div class="section-subtitle">Hardware & Networking</div>
            <h1 class="section-title">Luxenet Shop</h1>
            <p class="text-gray-400 max-w-xl mx-auto">Purchase premium, high-grade ethernet cables, network routers, and accessories directly integrated with our enterprise deployments.</p>
        </header>

        <div class="product-grid">
            @forelse($products as $product)
                <div class="product-card">
                    <a href="{{ route('shop.show', $product) }}" class="product-img-wrapper">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-img">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center bg-white/5">
                                <i class="fas fa-network-wired text-4xl text-gray-600"></i>
                            </div>
                        @endif
                    </a>
                    
                    <div class="product-info">
                        <a href="{{ route('shop.show', $product) }}" class="product-name hover:text-primary transition-all">{{ $product->name }}</a>
                        <p class="product-desc">{{ $product->description }}</p>
                        
                        <div class="product-footer">
                            <div class="product-price">UGX {{ number_format($product->selling_price, 2) }}</div>
                            <form action="{{ route('shop.cart.add', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-add-cart">
                                    <i class="fas fa-cart-plus"></i> Add
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 80px 20px; background: rgba(255,255,255,0.01); border: 1px dashed rgba(255,255,255,0.1); border-radius: 20px;">
                    <i class="fas fa-box-open text-5xl text-gray-600 mb-4"></i>
                    <h3 class="text-xl font-bold">No Products Available</h3>
                    <p class="text-gray-500 mt-2">We are currently updating our digital catalog. Please check back later!</p>
                </div>
            @endforelse
        </div>
    </main>

    <footer class="py-12 border-t border-white/5 mt-20 text-center">
        <p class="text-gray-600 text-sm">© {{ date('Y') }} Luxenet. All rights reserved.</p>
    </footer>

</body>
</html>
