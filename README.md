# Luxenet E‑Commerce Platform

## Overview

Luxenet is a Laravel‑based e‑commerce application that provides a full‑featured online shop for selling products. It includes product management, order handling, a Paystack payment integration, and an admin dashboard.

## Features
- Product catalog with categories, images, and pricing.
- Shopping cart and checkout flow.
- Paystack payment gateway integration (initialise and verify transactions).
- Order management for admins (view, update status, export).
- Responsive Blade templates for the storefront and admin panel.
- Environment based configuration (`.env`) for API keys, URLs, and database.

## Tech Stack
- **Backend**: Laravel 10 (PHP 8.2)
- **Database**: MySQL
- **Frontend**: Blade templating, TailwindCSS (via CDN), vanilla JavaScript
- **Payments**: Paystack REST API
- **Server**: Apache (WAMP) on Windows

## Installation
```bash
# Clone the repository (if you haven't already)
git clone <repository‑url>
cd luxenet

# Install PHP dependencies
composer install

# Copy example environment and set values
cp .env.example .env
# Edit .env – set database credentials, Paystack keys, and APP_URL

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Serve the application (development)
php artisan serve
```

## Configuration
| Variable | Description |
|---|---|
| `APP_URL` | Base URL of the site (e.g., `http://localhost` or `https://tech.luxenetworks.co.ke`). |
| `PAYSTACK_PUBLIC_KEY` | Your Paystack public key. |
| `PAYSTACK_SECRET_KEY` | Your Paystack secret key. |
| `PAYSTACK_CALLBACK_URL` *(optional)* | If set, overrides the default `/payment/callback` route. |

## Paystack Integration
- **Initialize Transaction** – `/payment/initialize` (POST) creates a transaction and returns an authorization URL.
- **Callback / Webhook** – Laravel route `GET /payment/callback` (see `routes/web.php`).
- **Verify Transaction** – `/payment/verify/{reference}` (GET) validates the payment.

### Live Callback URL
```
https://tech.luxenetworks.co.ke/payment/callback
```
Set this URL in your Paystack dashboard under **Webhooks → Add New Webhook**.

## Routes Overview (excerpt)
```php
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/payment/initialize', [ShopController::class, 'initialize'])->name('paystack.initialize');
Route::get('/payment/callback', [ShopController::class, 'callback'])->name('shop.callback');
```

## Contributing
1. Fork the repository.
2. Create a feature branch (`git checkout -b feature/your‑feature`).
3. Commit your changes (`git commit -m "Add ..."`).
4. Push to your fork (`git push origin feature/your‑feature`).
5. Open a Pull Request.

## License
This project is licensed under the MIT License.
