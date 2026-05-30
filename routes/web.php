<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CapacityRequestController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\SubscriberController;
Route::get('/', function () {
    $partners = \App\Models\Partner::orderBy('order')->get();
    $works = \App\Models\Work::orderBy('order')->get()->groupBy('category');
    $latestBlogs = \App\Models\Blog::where('is_published', true)->latest('published_at')->take(3)->get();
    $reviews = \App\Models\Review::where('approved', true)->latest()->get();
    return view('landing', compact('partners', 'works', 'latestBlogs', 'reviews'));
})->middleware(\App\Http\Middleware\TrackVisit::class);

Route::get('/storage/{path}', [\App\Http\Controllers\ImageController::class, 'show'])->where('path', '.*');

Route::get('/api/stats', function () {
    try {
        $today = \App\Models\Visit::whereDate('created_at', \Illuminate\Support\Carbon::today())->count();
        $active = \App\Models\Visit::where('created_at', '>=', \Illuminate\Support\Carbon::now()->subMinutes(5))
            ->distinct()
            ->count('ip_address');
        
        $regions = ['North Node', 'Central Hub', 'South Gateway', 'West Terminal', 'Coast Uplink'];
        $region = $regions[array_rand($regions)];
        
        return response()->json([
            'today' => $today,
            'active' => $active,
            'label' => $region,
            'time' => now()->format('H:i:s'),
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Google OAuth routes removed – reading blogs no longer requires Google sign‑in

Route::post('/capacity-request', [CapacityRequestController::class, 'store'])->name('capacity.request');

Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard')->middleware('auth');

// Tech Meet and Greet
use App\Http\Controllers\MeetGreetController;
Route::get('/meet-greet', [MeetGreetController::class, 'index'])->name('meet-greet');
Route::get('/meet-greet/register', [MeetGreetController::class, 'showRegister'])->name('meet-greet.register');
Route::post('/meet-greet/apply', [MeetGreetController::class, 'apply'])->name('meet-greet.apply');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/meet-greet', [MeetGreetController::class, 'adminIndex'])->name('meet-greet.index');
    Route::post('/meet-greet/settings', [MeetGreetController::class, 'updateSettings'])->name('meet-greet.settings.update');
    Route::post('/meet-greet/slides', [MeetGreetController::class, 'storeSlide'])->name('meet-greet.slides.store');
    Route::delete('/meet-greet/slides/{slide}', [MeetGreetController::class, 'deleteSlide'])->name('meet-greet.slides.delete');
    Route::post('/meet-greet/announcements', [MeetGreetController::class, 'storeAnnouncement'])->name('meet-greet.announcements.store');
    Route::post('/meet-greet/announcements/{announcement}/toggle', [MeetGreetController::class, 'toggleAnnouncement'])->name('meet-greet.announcements.toggle');
    Route::delete('/meet-greet/announcements/{announcement}', [MeetGreetController::class, 'deleteAnnouncement'])->name('meet-greet.announcements.delete');
    Route::delete('/meet-greet/applications/{application}', [MeetGreetController::class, 'deleteApplication'])->name('meet-greet.applications.delete');
    Route::patch('/meet-greet/applications/{application}/status', [MeetGreetController::class, 'updateApplicationStatus'])->name('meet-greet.applications.status');
    Route::get('/meet-greet/applications/export', [MeetGreetController::class, 'exportApplications'])->name('meet-greet.applications.export');

    // Partner Management
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'store'])->name('settings.store');

    Route::get('/partners', [AdminController::class, 'managePartners'])->name('partners.index');
    Route::post('/partners', [AdminController::class, 'storePartner'])->name('partners.store');
    Route::delete('/partners/{partner}', [AdminController::class, 'deletePartner'])->name('partners.delete');

    // Work Portfolio Management
    Route::get('/works', [AdminController::class, 'manageWorks'])->name('works.index');
    Route::post('/works', [AdminController::class, 'storeWork'])->name('works.store');
    Route::delete('/works/{work}', [AdminController::class, 'deleteWork'])->name('works.delete');

    // Invoices
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');
    Route::post('/invoices/{invoice}/payment', [InvoiceController::class, 'updatePayment'])->name('invoices.payment');
    Route::post('/invoices/{invoice}/clear', [InvoiceController::class, 'clear'])->name('invoices.clear');

    // Google Sign‑Ups
    Route::get('/google-signups', [\App\Http\Controllers\Admin\GoogleUserController::class, 'index'])->name('google.signups');

    // Mailing List
    Route::post('/subscribers/import', [\App\Http\Controllers\Admin\SubscriberController::class, 'import'])->name('subscribers.import');
    Route::resource('subscribers', \App\Http\Controllers\Admin\SubscriberController::class)->only(['index', 'store', 'destroy']);

    // Share blog with Google‑signed‑up users
    // Share blog with Google‑signed‑up users (custom action)
    Route::resource('blogs', AdminBlogController::class);
    Route::post('blogs/{blog}/share-google', [AdminBlogController::class, 'shareWithGoogle'])
        ->name('blogs.shareGoogle');



    Route::get('/top-blogs/export', [AdminController::class, 'exportTopBlogs'])->name('top_blogs.export');

    // Admin Shop Management
    Route::get('/shop', [\App\Http\Controllers\Admin\ShopManagementController::class, 'index'])->name('shop.index');
    Route::post('/shop/product', [\App\Http\Controllers\Admin\ShopManagementController::class, 'storeProduct'])->name('shop.store');
    Route::patch('/shop/product/{product}', [\App\Http\Controllers\Admin\ShopManagementController::class, 'updateProduct'])->name('shop.update');
    Route::delete('/shop/product/{product}', [\App\Http\Controllers\Admin\ShopManagementController::class, 'deleteProduct'])->name('shop.delete');
    Route::get('/shop/orders', [\App\Http\Controllers\Admin\ShopManagementController::class, 'orders'])->name('shop.orders');
    Route::patch('/shop/orders/{order}', [\App\Http\Controllers\Admin\ShopManagementController::class, 'updateOrderStatus'])->name('shop.orders.update');
    // These routes are named admin.shop.* because they live inside the admin middleware group

    // Admin Review Management
    Route::get('/reviews', [\App\Http\Controllers\Admin\ReviewManagementController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{review}/approve', [\App\Http\Controllers\Admin\ReviewManagementController::class, 'approve'])->name('reviews.approve');
    Route::delete('/reviews/{review}', [\App\Http\Controllers\Admin\ReviewManagementController::class, 'destroy'])->name('reviews.delete');
});

Route::post('/reviews', [\App\Http\Controllers\Admin\ReviewManagementController::class, 'store'])->name('reviews.store');

// Public Shop Routes
Route::get('/shop', [\App\Http\Controllers\ShopController::class, 'index'])->name('shop.catalog');
Route::get('/shop/product/{product}', [\App\Http\Controllers\ShopController::class, 'show'])->name('shop.show');
Route::get('/cart', [\App\Http\Controllers\ShopController::class, 'cart'])->name('shop.cart');
Route::post('/cart/add/{product}', [\App\Http\Controllers\ShopController::class, 'addToCart'])->name('shop.cart.add');
Route::post('/cart/remove/{id}', [\App\Http\Controllers\ShopController::class, 'removeFromCart'])->name('shop.cart.remove');
Route::post('/checkout', [\App\Http\Controllers\ShopController::class, 'checkout'])->name('shop.checkout');
Route::get('/payment/callback', [\App\Http\Controllers\ShopController::class, 'callback'])->name('shop.callback');

// Public Blogs
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('blogs.show');
Route::post('/subscribe', [SubscriberController::class, 'store'])->name('subscribers.store');
Route::get('/download-app', function () {
    return view('blogs.download-app');
})->name('app.download');

// Block access to common scanner paths like phpmyadmin
Route::any('/phpmyadmin', function () {
    abort(404);
});
Route::any('/pma', function () {
    abort(404);
});

