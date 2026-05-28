# Turks Official Product Images Patch

This patch does not touch your `.env` file.

## Apply on Windows

1. Extract this patch zip.
2. Copy the two folders/files into your existing project:

- `public/assets/images/products` -> `C:\Users\Charles\Herd\turks-kiosk-web-admin\public\assets\images\products`
- `database/seeders/ProductSeeder.php` -> `C:\Users\Charles\Herd\turks-kiosk-web-admin\database\seeders\ProductSeeder.php`

3. Run:

```bash
cd C:\Users\Charles\Herd\turks-kiosk-web-admin
php artisan config:clear
php artisan cache:clear
php artisan db:seed --class=ProductSeeder
```

If you want to fully reset sample products/orders, run:

```bash
php artisan migrate:fresh --seed
```

Only run `migrate:fresh --seed` if you are okay deleting existing database records.
