# Supabase Setup for Turks Kiosk Web Admin

## 1. Create the Laravel schema

In Supabase SQL Editor, run:

```sql
create schema if not exists laravel;
```

## 2. Configure `.env`

Copy `.env.example` to `.env` and set:

```env
APP_NAME="Turks Kiosk Web Admin"
DB_CONNECTION=pgsql
DB_URL="postgresql://postgres.YOUR_PROJECT_REF:YOUR_PASSWORD@YOUR_POOLER_HOST:5432/postgres"
DB_SCHEMA=laravel
DB_SSLMODE=require
SESSION_DRIVER=file
```

Use your Supabase Session Pooler string. Do not include square brackets around your password.

## 3. Enable PostgreSQL extensions in Herd

In Herd, enable these PHP extensions if migration fails with `could not find driver`:

```txt
pgsql
pdo_pgsql
```

Restart Herd, then run:

```bash
php artisan config:clear
php artisan migrate:fresh --seed
```

## 4. Verify in Supabase

Go to:

```txt
Supabase Dashboard > Table Editor > Schema dropdown > laravel
```

You should see:

```txt
users
categories
products
orders
order_items
```
