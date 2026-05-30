<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $products = \App\Models\Product::where('stock', '>', 0)->latest()->get();
        return view('shop.index', compact('products'));
    }

    public function show(\App\Models\Product $product)
    {
        return view('shop.show', compact('product'));
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('shop.cart', compact('cart', 'total'));
    }

    public function addToCart(Request $request, \App\Models\Product $product)
    {
        $cart = session()->get('cart', []);
        
        $quantity = $request->input('quantity', 1);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'quantity' => $quantity,
                'price' => $product->selling_price,
                'image' => $product->image_url
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->route('shop.cart')->with('success', 'Product removed from cart');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop.catalog')->with('error', 'Your cart is empty');
        }

        $itemsTotal = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        // Online discount for web checkout
        $discount = 10000;

        // Delivery
        $deliveryZone = $request->input('delivery_zone', 'kampala');
        $deliveryFee  = $deliveryZone === 'kampala' ? 10000 : 0; // courier billed separately
        $deliveryNote = $deliveryZone === 'kampala'
            ? 'Within Kampala — UGX 10,000 delivery'
            : 'Outside Kampala — courier/bus charges apply';

        $grandTotal = max(0, $itemsTotal - $discount + $deliveryFee);

        // Create Order
        $order = \App\Models\Order::create([
            'user_id'             => auth()->id(),
            'total_amount'        => $grandTotal,
            'status'              => 'pending',
            'paystack_reference'  => 'LXT_' . uniqid() . '_' . time(),
            'notes'               => $deliveryNote . ' | Online discount applied: UGX 10,000',
        ]);

        foreach ($cart as $id => $item) {
            \App\Models\OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $id,
                'quantity'   => $item['quantity'],
                'unit_price' => $item['price'],
            ]);
        }

        // Initialize Paystack
        $url = "https://api.paystack.co/transaction/initialize";
        $fields = [
            'email'        => auth()->check() ? auth()->user()->email : 'guest@luxenetworks.co.ke',
            'amount'       => $grandTotal * 100, // in kobo/cents
            'reference'    => $order->paystack_reference,
            'callback_url' => route('shop.callback'),
            'currency'     => 'KES',
            'metadata'     => [
                'delivery_zone' => $deliveryZone,
                'delivery_fee'  => $deliveryFee,
                'discount'      => $discount,
                'order_id'      => $order->id,
            ],
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . env('PAYSTACK_SECRET_KEY'),
            "Cache-Control: no-cache",
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CAINFO, 'C:\\wamp64\\bin\\php\\cacert.pem');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return redirect()->route('shop.cart')->with('error', 'Payment initialization failed: ' . $err);
        }

        $response = json_decode($result, true);

        if ($response['status']) {
            return redirect($response['data']['authorization_url']);
        }

        return redirect()->route('shop.cart')->with('error', 'Payment gateway error: ' . $response['message']);
    }

    public function callback(Request $request)
    {
        $reference = $request->query('reference');
        if (!$reference) {
            return redirect()->route('shop.catalog')->with('error', 'No reference supplied');
        }

        $url = "https://api.paystack.co/transaction/verify/" . rawurlencode($reference);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . env('PAYSTACK_SECRET_KEY'),
            "Cache-Control: no-cache",
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CAINFO, 'C:\\wamp64\\bin\\php\\cacert.pem'); // Fix SSL on WampServer
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        
        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result, true);

        if ($response && $response['status']) {
            if ($response['data']['status'] === 'success') {
                $order = \App\Models\Order::where('paystack_reference', $reference)->first();
                if ($order && $order->status !== 'paid') {
                    $order->update([
                        'status' => 'paid',
                        'paid_at' => now(),
                    ]);
                    // Clear cart
                    session()->forget('cart');
                    return redirect()->route('shop.catalog')->with('success', 'Payment successful! Order confirmed.');
                }
            }
        }

        return redirect()->route('shop.catalog')->with('error', 'Payment verification failed.');
    }
}
