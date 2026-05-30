<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $product->name }} | Luxenet Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background-color: #060d14; color: white; font-family: 'Inter', sans-serif; }
        .product-container { max-width: 1000px; margin: 0 auto; padding: 140px 5% 60px; }
        
        .product-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: start;
        }
        
        @media(max-width: 768px) {
            .product-layout { grid-template-columns: 1fr; gap: 30px; }
        }
        
        .product-gallery {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            aspect-ratio: 1;
        }
        
        .product-gallery img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .meta-subtitle {
            color: #b8962a;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 12px;
        }
        
        .product-title {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 15px;
        }
        
        .product-price {
            font-size: 2rem;
            font-weight: 800;
            color: #b8962a;
            margin-bottom: 25px;
        }
        
        .product-description {
            color: #9ca3af;
            font-size: 1rem;
            line-height: 1.7;
            margin-bottom: 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding-bottom: 25px;
        }
        
        .stock-indicator {
            font-size: 0.875rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 25px;
        }
        
        .qty-selector {
            display: flex;
            align-items: center;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 4px;
            max-width: 130px;
        }
        
        .qty-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.1rem;
            cursor: pointer;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s;
        }
        
        .qty-btn:hover {
            background: rgba(255,255,255,0.1);
        }
        
        .qty-input {
            width: 50px;
            text-align: center;
            background: none;
            border: none;
            color: white;
            font-weight: 700;
            font-size: 1rem;
        }
        
        .qty-input::-webkit-outer-spin-button,
        .qty-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        
        .btn-add-to-cart {
            background: linear-gradient(135deg, #b8962a, #d4af37);
            color: #060d14;
            font-weight: 700;
            font-size: 1rem;
            padding: 15px 35px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            flex-grow: 1;
        }
        
        .btn-add-to-cart:hover {
            opacity: 0.95;
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(184, 150, 42, 0.4);
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

    <main class="product-container">
        @if(session('success'))
            <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399; padding: 15px; border-radius: 12px; margin-bottom: 30px; font-weight: 600; text-align: center;">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('shop.catalog') }}" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-primary mb-8 transition-all">
            <i class="fas fa-arrow-left"></i> Back to Catalog
        </a>

        <div class="product-layout">
            <div class="product-gallery">
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                @else
                    <i class="fas fa-network-wired text-7xl text-gray-700"></i>
                @endif
            </div>
            
            <div class="product-details">
                <div class="meta-subtitle">Hardware Catalogue</div>
                <h1 class="product-title">{{ $product->name }}</h1>
                <div class="product-price">UGX {{ number_format($product->selling_price, 2) }}</div>
                
                <div class="product-description">
                    {{ $product->description ?? 'No specific detailed description provided for this device. Underwent full enterprise grading and structural testing.' }}
                </div>
                
                <div class="stock-indicator">
                    @if($product->stock > 5)
                        <i class="fas fa-check-circle text-green-500"></i>
                        <span class="text-green-400">In Stock ({{ $product->stock }} items remaining)</span>
                    @elseif($product->stock > 0)
                        <i class="fas fa-exclamation-circle text-yellow-500"></i>
                        <span class="text-yellow-400">Low Stock (Only {{ $product->stock }} items left)</span>
                    @else
                        <i class="fas fa-times-circle text-red-500"></i>
                        <span class="text-red-400">Out of Stock</span>
                    @endif
                </div>

                @if($product->stock > 0)
                    <form action="{{ route('shop.cart.add', $product) }}" method="POST" class="flex gap-4 items-center">
                        @csrf
                        <div class="qty-selector">
                            <button type="button" class="qty-btn" onclick="adjustQty(-1)"><i class="fas fa-minus text-xs"></i></button>
                            <input type="number" name="quantity" id="quantity-input" value="1" min="1" max="{{ $product->stock }}" class="qty-input">
                            <button type="button" class="qty-btn" onclick="adjustQty(1)"><i class="fas fa-plus text-xs"></i></button>
                        </div>
                        
                        <button type="submit" class="btn-add-to-cart">
                            <i class="fas fa-shopping-basket"></i> Add to Basket
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </main>

    <footer class="py-12 border-t border-white/5 mt-20 text-center">
        <p class="text-gray-600 text-sm">© {{ date('Y') }} Luxenet. All rights reserved.</p>
    </footer>

    <script>
        function adjustQty(amount) {
            const input = document.getElementById('quantity-input');
            let current = parseInt(input.value) || 1;
            let target = current + amount;
            let min = parseInt(input.min) || 1;
            let max = parseInt(input.max) || 999;
            
            if (target >= min && target <= max) {
                input.value = target;
            }
        }
    </script>
</body>
</html>
