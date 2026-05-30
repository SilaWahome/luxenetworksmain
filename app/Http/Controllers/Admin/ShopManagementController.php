<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShopManagementController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('admin.shop.index', compact('products'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'stock' => 'required|integer|min:0',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Store clean relative path; the model accessor builds the full URL
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'cost_price' => $request->cost_price,
            'selling_price' => $request->selling_price,
            'image_url' => $imagePath,
            'stock' => $request->stock,
        ]);

        return back()->with('success', 'Product added successfully.');
    }

    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'stock' => 'required|integer|min:0',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'cost_price' => $request->cost_price,
            'selling_price' => $request->selling_price,
            'stock' => $request->stock,
        ];

        if ($request->hasFile('image')) {
            // Delete old image if exists (use getRawOriginal to bypass accessor)
            $rawPath = $product->getRawOriginal('image_url');
            if ($rawPath) {
                $cleanPath = ltrim($rawPath, '/');
                if (str_starts_with($cleanPath, 'storage/')) {
                    $cleanPath = substr($cleanPath, strlen('storage/'));
                }
                Storage::disk('public')->delete($cleanPath);
            }

            // Store clean relative path
            $data['image_url'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return back()->with('success', 'Product updated successfully.');
    }

    public function deleteProduct(Product $product)
    {
        // Use getRawOriginal to bypass accessor and get the stored path
        $rawPath = $product->getRawOriginal('image_url');
        if ($rawPath) {
            $cleanPath = ltrim($rawPath, '/');
            if (str_starts_with($cleanPath, 'storage/')) {
                $cleanPath = substr($cleanPath, strlen('storage/'));
            }
            Storage::disk('public')->delete($cleanPath);
        }
        $product->delete();
        return back()->with('success', 'Product deleted successfully.');
    }

    public function orders()
    {
        $orders = Order::with(['user', 'items.product'])->orderBy('id', 'desc')->get();
        return view('admin.shop.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,failed',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated successfully.');
    }
}
