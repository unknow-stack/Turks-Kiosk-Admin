# Setup on Windows + Laravel Herd

## A. Put the project inside Herd

Extract the ZIP to:

```txt
C:\Users\Charles\Herd\turks-kiosk-web-admin
```

Then open Command Prompt:

```bash
cd C:\Users\Charles\Herd\turks-kiosk-web-admin
```

## B. Install PHP dependencies

```bash
composer install
```

## C. Create `.env`

```bash
copy .env.example .env
```

Open `.env` and paste your Supabase Session Pooler value into `DB_URL`.

Keep this:

```env
DB_CONNECTION=pgsql
DB_SCHEMA=laravel
DB_SSLMODE=require
SESSION_DRIVER=file
```

## D. Create schema in Supabase

In Supabase SQL Editor:

```sql
create schema if not exists laravel;
```

## E. Generate key and migrate

```bash
php artisan key:generate
php artisan config:clear
php artisan storage:link
php artisan migrate:fresh --seed
```

## F. Open the admin

Herd URL:

```txt
http://turks-kiosk-web-admin.test/login
```

Or artisan serve:

```bash
php artisan serve
```

Then open:

```txt
http://127.0.0.1:8000/login
```

## G. Login

```txt
Email: admin@turkskiosk.test
Password: password
```

## H. API test

```txt
http://127.0.0.1:8000/api/products
```

or with Herd:

```txt
http://turks-kiosk-web-admin.test/api/products
```
