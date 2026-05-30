# Luxenetworks Main

## Overview

Luxenetworks is a Laravel‑based e‑commerce platform that enables users to browse products, add items to a cart, and checkout using **Paystack**. The application includes an admin dashboard for managing products, orders, and shop settings.

## Tech Stack

- **Framework**: Laravel 10 (PHP 8.2)
- **Database**: MySQL
- **Front‑end**: Blade templating, Bootstrap, FontAwesome
- **Payments**: Paystack API (transaction initialization and verification)
- **Version Control**: Git, hosted on GitHub (`https://github.com/SilaWahome/luxenetworksmain`)

## Key Features

- Product catalog with categories
- Shopping cart and order management
- Admin interface for product CRUD, order tracking, and shop settings
- Paystack integration for secure online payments
- Email notifications for order confirmations
- Environment‑specific configuration (`.env`), with `APP_URL` set to the live site (`https://tech.luxenetworks.co.ke`)

## Installation & Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/SilaWahome/luxenetworksmain.git
   cd luxenetworksmain
   ```
2. **Install dependencies** (Composer)
   ```bash
   composer install
   ```
3. **Create an environment file**
   ```bash
   cp .env.example .env
   ```
   Update the following variables:
   - `APP_URL=https://tech.luxenetworks.co.ke`
   - Database credentials (`DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`)
   - Paystack keys (`PAYSTACK_PUBLIC_KEY`, `PAYSTACK_SECRET_KEY`)
4. **Generate application key**
   ```bash
   php artisan key:generate
   ```
5. **Run migrations**
   ```bash
   php artisan migrate
   ```
6. **Start the development server**
   ```bash
   php artisan serve
   ```

## Paystack Integration

- **Initialization**: Controller method `ShopController::initialize` sends a POST request to `https://api.paystack.co/transaction/initialize` with the order amount and reference.
- **Verification**: After payment, Paystack redirects to the callback URL:
  ```
  https://tech.luxenetworks.co.ke/payment/callback
  ```
  This route is defined in `routes/web.php` and handled by `ShopController::callback` to verify the transaction and update the order status.
- **Webhook (optional)**: You can also configure a Paystack webhook pointing to the same callback URL for server‑to‑server verification.

## Routes Overview

| Method | URI | Controller | Purpose |
|--------|-----|------------|---------|
| GET | `/` | `HomeController@index` | Landing page |
| GET | `/shop` | `ShopController@index` | List products |
| POST | `/checkout` | `ShopController@initialize` | Create Paystack transaction |
| GET | `/payment/callback` | `ShopController@callback` | Verify Paystack payment |
| GET | `/admin/*` | `Admin\*` | Admin dashboard (product, order management) |

## Development Guidelines

- Follow PSR‑12 coding standards.
- Use Laravel’s built‑in validation for all request inputs.
- Keep secrets out of the repository – store them only in `.env`.
- Run `php artisan test` (if tests are added) before committing.

## Contributing

1. Fork the repository.
2. Create a feature branch (`git checkout -b feature/your-feature`).
3. Commit your changes (`git commit -m "Add …"`).
4. Push the branch (`git push origin feature/your-feature`).
5. Open a Pull Request on GitHub.

## License

This project is licensed under the **MIT License**.
