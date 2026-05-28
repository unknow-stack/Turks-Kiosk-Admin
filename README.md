# Turks Kiosk Web Admin

Laravel web admin for a Turks-themed kiosk ordering system. The admin manages categories, products/menu, orders, kitchen order flow, and sales reports. It also exposes REST API endpoints for a Flutter kiosk/mobile app.

## Included modules

- Admin login
- Dashboard
- Product/menu management
- Category management
- Orders API for Flutter
- Order management
- Kitchen order screen
- Sales report
- Supabase PostgreSQL configuration

## Demo admin account

```txt
Email: admin@turkskiosk.test
Password: password
```

Change these through `.env` before running the seeders if you want a different seeded admin.

## Important note about menu data

The seeded product data is sample/demo data for the school project. Use the admin product screen to encode your final Turks menu references and prices.

## Quick commands

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan config:clear
php artisan storage:link
php artisan migrate:fresh --seed
php artisan serve
```

Then open:

```txt
http://127.0.0.1:8000/login
```

If using Laravel Herd, open:

```txt
http://turks-kiosk-web-admin.test/login
```
