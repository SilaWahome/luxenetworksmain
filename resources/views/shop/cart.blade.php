<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Your Cart | Luxenet Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background-color: #060d14; color: white; font-family: 'Inter', sans-serif; }

        .cart-container { max-width: 1100px; margin: 0 auto; padding: 130px 5% 80px; }
        .cart-header { border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 20px; margin-bottom: 40px; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 16px; }
        .cart-title { font-size: 2.25rem; font-weight: 800; }

        /* ---- Promo Banner ---- */
        .promo-banner {
            background: linear-gradient(135deg, rgba(184,150,42,0.15), rgba(212,175,55,0.08));
            border: 1px solid rgba(184,150,42,0.35);
            border-radius: 16px;
            padding: 16px 22px;
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 32px;
            animation: pulse-glow 2.5s ease-in-out infinite;
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(184,150,42,0); }
            50% { box-shadow: 0 0 20px 4px rgba(184,150,42,0.12); }
        }
        .promo-icon { font-size: 1.6rem; }
        .promo-text strong { color: #d4af37; font-size: 1.05rem; }
        .promo-text p { color: rgba(255,255,255,0.6); font-size: 0.85rem; margin-top: 2px; }
        .promo-badge { margin-left: auto; background: #b8962a; color: #060d14; font-weight: 800; font-size: 0.8rem; padding: 6px 14px; border-radius: 20px; white-space: nowrap; letter-spacing: 0.03em; text-transform: uppercase; }

        .cart-layout {
            display: grid;
            grid-template-columns: 1.6fr 1fr;
            gap: 36px;
            align-items: start;
        }
        @media(max-width: 800px) { .cart-layout { grid-template-columns: 1fr; } }

        .cart-item-list {
            background: rgba(255,255,255,0.01);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 20px;
            overflow: hidden;
        }
        .cart-item {
            display: flex;
            align-items: center;
            padding: 22px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            gap: 18px;
            transition: background 0.2s;
        }
        .cart-item:hover { background: rgba(255,255,255,0.015); }
        .cart-item:last-child { border-bottom: none; }
        .cart-item-img {
            width: 70px; height: 70px; flex-shrink: 0;
            object-fit: cover; border-radius: 12px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.05);
            display: flex; align-items: center; justify-content: center; overflow: hidden;
        }
        .cart-item-info { flex-grow: 1; }
        .cart-item-name { font-weight: 700; font-size: 1rem; margin-bottom: 4px; color: white; }
        .cart-item-price { color: #b8962a; font-weight: 700; font-size: 0.9rem; }
        .cart-item-quantity { color: #9ca3af; font-size: 0.82rem; margin-top: 3px; }
        .btn-remove-item { background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1rem; transition: opacity 0.2s; padding: 8px; }
        .btn-remove-item:hover { opacity: 0.7; }

        /* ---- Summary Card ---- */
        .summary-card {
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px;
            padding: 28px;
            position: sticky;
            top: 100px;
        }
        .summary-title { font-size: 1.15rem; font-weight: 700; margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 14px; }
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 13px; font-size: 0.9rem; color: #9ca3af; }
        .summary-row.highlight { color: white; }
        .summary-total-row {
            display: flex; justify-content: space-between;
            margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.06);
            padding-top: 18px; font-weight: 800; font-size: 1.2rem; color: white;
        }
        .discount-row { color: #4ade80 !important; }
        .discount-val { color: #4ade80; font-weight: 700; }

        /* ---- Delivery Selector ---- */
        .delivery-section { margin: 20px 0 18px; }
        .delivery-label { font-size: 0.85rem; color: #9ca3af; margin-bottom: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.07em; }
        .delivery-options { display: flex; flex-direction: column; gap: 10px; }
        .delivery-option {
            display: flex; align-items: flex-start; gap: 12px;
            padding: 14px 16px;
            border: 1.5px solid rgba(255,255,255,0.07);
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.25s ease;
            background: rgba(255,255,255,0.01);
        }
        .delivery-option:hover { border-color: rgba(184,150,42,0.4); background: rgba(184,150,42,0.04); }
        .delivery-option.selected { border-color: #b8962a; background: rgba(184,150,42,0.08); }
        .delivery-option input[type="radio"] { accent-color: #b8962a; margin-top: 2px; flex-shrink: 0; }
        .delivery-option-label { font-size: 0.9rem; font-weight: 600; color: white; }
        .delivery-option-sub { font-size: 0.78rem; color: #9ca3af; margin-top: 3px; line-height: 1.4; }
        .delivery-option-price { margin-left: auto; font-weight: 800; font-size: 0.95rem; color: #b8962a; white-space: nowrap; padding-left: 10px; }
        .courier-note {
            font-size: 0.78rem; color: rgba(255,180,0,0.85);
            background: rgba(255,180,0,0.06); border: 1px solid rgba(255,180,0,0.15);
            border-radius: 10px; padding: 10px 13px; margin-top: 8px; display: none;
            line-height: 1.5;
        }
        .courier-note.visible { display: block; }

        /* ---- Checkout Btn ---- */
        .btn-checkout {
            background: linear-gradient(135deg, #b8962a, #d4af37);
            color: #060d14; font-weight: 800; font-size: 1rem;
            width: 100%; padding: 15px; border-radius: 14px; border: none;
            cursor: pointer; transition: all 0.3s ease;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            margin-top: 22px; letter-spacing: 0.01em;
        }
        .btn-checkout:hover { opacity: 0.95; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(184,150,42,0.35); }
        .btn-checkout:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

        /* ---- WhatsApp Quick Order ---- */
        .whatsapp-panel {
            margin-top: 16px;
            background: rgba(37,211,102,0.06);
            border: 1px solid rgba(37,211,102,0.2);
            border-radius: 16px;
            padding: 18px 20px;
            text-align: center;
        }
        .wa-divider { font-size: 0.75rem; color: rgba(255,255,255,0.3); margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.08em; }
        .btn-whatsapp {
            display: flex; align-items: center; justify-content: center; gap: 10px;
            background: #25d366; color: white; font-weight: 700; font-size: 0.9rem;
            padding: 12px 20px; border-radius: 12px; text-decoration: none;
            transition: all 0.3s; width: 100%;
        }
        .btn-whatsapp:hover { background: #1ebe5d; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(37,211,102,0.3); }
        .wa-note { font-size: 0.75rem; color: rgba(255,255,255,0.4); margin-top: 10px; line-height: 1.5; }
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
            <a href="{{ route('shop.cart') }}" class="cart-badge-nav text-white text-lg mr-4" style="color: var(--primary);">
                <i class="fas fa-shopping-cart"></i>
                @php $cartCount = count(session()->get('cart', [])); @endphp
                @if($cartCount > 0)
                    <span class="cart-count">{{ $cartCount }}</span>
                @endif
            </a>
            <a href="{{ route('login') }}" class="btn-login"><i class="fas fa-user mr-2"></i> Partner Portal</a>
        </div>
    </nav>

    <main class="cart-container">

        @if(session('error'))
            <div style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); color: #f87171; padding: 15px; border-radius: 12px; margin-bottom: 24px; font-weight: 600; text-align: center;">
                {{ session('error') }}
            </div>
        @endif

        <div class="cart-header">
            <h1 class="cart-title">Your Basket</h1>
            <a href="{{ route('shop.catalog') }}" style="font-size: 0.9rem; color: var(--primary); display: flex; align-items: center; gap: 6px;">
                <i class="fas fa-arrow-left" style="font-size: 0.8rem;"></i> Continue Shopping
            </a>
        </div>

        @if(!empty($cart))

            {{-- Promo Banner --}}
            <div class="promo-banner">
                <div class="promo-icon">🎉</div>
                <div class="promo-text">
                    <strong>Online Order Discount — Save UGX 10,000!</strong>
                    <p>A special discount is automatically applied when you check out on our website.</p>
                </div>
                <div class="promo-badge">- UGX 10,000</div>
            </div>

            <div class="cart-layout">
                {{-- Cart Items --}}
                <div class="cart-item-list">
                    @foreach($cart as $id => $item)
                        <div class="cart-item">
                            <div class="cart-item-img">
                                @if($item['image'])
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" style="width:100%; height:100%; object-fit:cover; border-radius:10px;">
                                @else
                                    <i class="fas fa-network-wired" style="font-size:1.5rem; color: rgba(255,255,255,0.15);"></i>
                                @endif
                            </div>
                            <div class="cart-item-info">
                                <h3 class="cart-item-name">{{ $item['name'] }}</h3>
                                <div class="cart-item-price">UGX {{ number_format($item['price']) }}</div>
                                <div class="cart-item-quantity">Qty: <span style="color:white; font-weight:700;">{{ $item['quantity'] }}</span></div>
                            </div>
                            <div>
                                <form action="{{ route('shop.cart.remove', $id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-remove-item" title="Remove">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Order Summary --}}
                <div class="summary-card">
                    <h2 class="summary-title"><i class="fas fa-receipt" style="color:var(--primary); margin-right:8px;"></i>Order Summary</h2>

                    <div class="summary-row">
                        <span>Items Subtotal</span>
                        <span>UGX {{ number_format($total) }}</span>
                    </div>
                    <div class="summary-row discount-row">
                        <span>🎉 Online Discount</span>
                        <span class="discount-val">- UGX 10,000</span>
                    </div>

                    {{-- Delivery Zone Selector --}}
                    <div class="delivery-section">
                        <div class="delivery-label"><i class="fas fa-truck" style="margin-right:6px;"></i>Delivery Zone</div>
                        <div class="delivery-options">

                            <label class="delivery-option selected" id="opt-kampala" onclick="selectDelivery('kampala', this)">
                                <input type="radio" name="delivery_zone" value="kampala" checked>
                                <div style="flex:1">
                                    <div class="delivery-option-label">Within Kampala</div>
                                    <div class="delivery-option-sub">Standard delivery within Kampala city and suburbs.</div>
                                </div>
                                <div class="delivery-option-price">UGX 10,000</div>
                            </label>

                            <label class="delivery-option" id="opt-outside" onclick="selectDelivery('outside', this)">
                                <input type="radio" name="delivery_zone" value="outside">
                                <div style="flex:1">
                                    <div class="delivery-option-label">Outside Kampala</div>
                                    <div class="delivery-option-sub">Upcountry delivery — courier/bus charges apply.</div>
                                </div>
                                <div class="delivery-option-price" style="color:#f59e0b;">Courier</div>
                            </label>

                        </div>

                        <div class="courier-note" id="courier-note">
                            <i class="fas fa-info-circle" style="color:#f59e0b; margin-right:6px;"></i>
                            <strong style="color:#f59e0b;">Bus/Courier charges apply.</strong>
                            Your order will be dispatched via a trusted courier or bus service to your nearest town. Our team will contact you to arrange delivery details.
                            <br><br>
                            📲 WhatsApp us at <strong style="color:white;">+256 763 206 676</strong> to confirm your upcountry location and get a delivery quote.
                        </div>
                    </div>

                    <div class="summary-row highlight" id="delivery-fee-row">
                        <span>Delivery Fee</span>
                        <span id="delivery-fee-display">UGX 10,000</span>
                    </div>

                    <div class="summary-total-row">
                        <span>Grand Total</span>
                        <span style="color: var(--primary);" id="grand-total">UGX {{ number_format($total - 10000 + 10000) }}</span>
                    </div>

                    <form action="{{ route('shop.checkout') }}" method="POST" id="checkout-form">
                        @csrf
                        <input type="hidden" name="delivery_zone" id="delivery-zone-input" value="kampala">
                        <input type="hidden" name="delivery_fee" id="delivery-fee-input" value="10000">
                        <button type="submit" class="btn-checkout" id="checkout-btn">
                            <i class="fas fa-lock"></i> Secure Checkout — Pay with Paystack
                        </button>
                    </form>

                    {{-- WhatsApp Quick Order --}}
                    <div class="whatsapp-panel">
                        <div class="wa-divider">⚡ OR Quick Order via</div>
                        @php
                            $waItems = collect(session()->get('cart', []))->map(fn($i) => "{$i['quantity']}x {$i['name']}")->join(', ');
                            $waMsg = urlencode("Hi Luxenet! I'd like to order: {$waItems}. Please assist with delivery.");
                        @endphp
                        <a href="https://wa.me/256763206676?text={{ $waMsg }}" target="_blank" class="btn-whatsapp">
                            <i class="fab fa-whatsapp" style="font-size:1.3rem;"></i> Order on WhatsApp
                        </a>
                        <p class="wa-note">
                            <i class="fas fa-phone" style="color:#25d366; margin-right:4px;"></i>
                            <strong style="color:white;">+256 763 206 676</strong><br>
                            Send us your order via WhatsApp for quick assistance &amp; instant response.
                        </p>
                    </div>
                </div>
            </div>

        @else
            <div style="text-align: center; padding: 80px 20px; background: rgba(255,255,255,0.01); border: 1px dashed rgba(255,255,255,0.08); border-radius: 24px;">
                <i class="fas fa-shopping-basket" style="font-size:3.5rem; color: rgba(255,255,255,0.08); display:block; margin-bottom:20px;"></i>
                <h3 style="font-size:1.5rem; font-weight:700;">Your basket is empty</h3>
                <p style="color:#6b7280; margin-top:8px; max-width:400px; margin-inline:auto;">Looks like you haven't added anything yet. Head back to the store to explore our catalog.</p>
                <a href="{{ route('shop.catalog') }}" class="btn-login inline-flex items-center gap-2 mt-6">
                    <i class="fas fa-arrow-left"></i> Return to Shop
                </a>

                {{-- WhatsApp Quick Order for empty cart too --}}
                <div style="margin-top: 40px; max-width: 380px; margin-inline: auto;">
                    <div class="whatsapp-panel">
                        <div class="wa-divider">⚡ Know what you need? Order directly</div>
                        <a href="https://wa.me/256763206676?text={{ urlencode('Hi Luxenet! I\'d like to make an order. Please assist.') }}" target="_blank" class="btn-whatsapp">
                            <i class="fab fa-whatsapp" style="font-size:1.3rem;"></i> Chat with Us on WhatsApp
                        </a>
                        <p class="wa-note">
                            <strong style="color:white;">+256 763 206 676</strong><br>
                            Tell us what item you need — we'll respond instantly!
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </main>

    <footer class="py-12 border-t border-white/5 mt-20 text-center">
        <p style="color:#374151; font-size:0.875rem;">© {{ date('Y') }} Luxenet. All rights reserved.</p>
    </footer>

    <script>
        const itemsTotal = {{ $total }};
        const discount   = 10000;

        function selectDelivery(zone, el) {
            // Update selected styling
            document.querySelectorAll('.delivery-option').forEach(o => o.classList.remove('selected'));
            el.classList.add('selected');

            const feeDisplay = document.getElementById('delivery-fee-display');
            const grandTotal = document.getElementById('grand-total');
            const deliveryInput = document.getElementById('delivery-zone-input');
            const feeInput = document.getElementById('delivery-fee-input');
            const courierNote = document.getElementById('courier-note');
            const checkoutBtn = document.getElementById('checkout-btn');
            const feeRow = document.getElementById('delivery-fee-row');

            deliveryInput.value = zone;

            if (zone === 'kampala') {
                const fee = 10000;
                feeInput.value = fee;
                feeDisplay.textContent = 'UGX 10,000';
                feeRow.style.color = '';
                grandTotal.textContent = 'UGX ' + formatNumber(itemsTotal - discount + fee);
                checkoutBtn.disabled = false;
                checkoutBtn.innerHTML = '<i class="fas fa-lock"></i> Secure Checkout — Pay with Paystack';
                courierNote.classList.remove('visible');
            } else {
                // Outside Kampala — courier charges not fixed
                feeInput.value = 0;
                feeDisplay.innerHTML = '<span style="color:#f59e0b;">Courier charges apply</span>';
                feeRow.style.color = '#f59e0b';
                grandTotal.textContent = 'UGX ' + formatNumber(itemsTotal - discount) + ' + courier';
                checkoutBtn.disabled = false;
                checkoutBtn.innerHTML = '<i class="fas fa-lock"></i> Proceed — Courier Charges Billed Separately';
                courierNote.classList.add('visible');
            }
        }

        function formatNumber(n) {
            return n.toLocaleString('en-UG');
        }

        // Init grand total display
        document.getElementById('grand-total').textContent = 'UGX ' + formatNumber(itemsTotal - discount + 10000);
    </script>

</body>
</html>
