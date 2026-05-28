# Flutter API Guide

Base URL while local:

```txt
http://127.0.0.1:8000/api
```

Base URL after hosting:

```txt
https://your-hosted-domain.com/api
```

## Endpoints

### Health check

```http
GET /api/health
```

### Categories

```http
GET /api/categories
```

### Products

```http
GET /api/products
GET /api/products?category_id=1
GET /api/products?search=beef
GET /api/products/{id}
```

### Create order

```http
POST /api/orders
Content-Type: application/json
```

Body:

```json
{
  "customer_name": "Guest 001",
  "customer_contact": "",
  "order_type": "kiosk",
  "payment_method": "mock",
  "payment_status": "unpaid",
  "notes": "No onions",
  "items": [
    { "product_id": 1, "quantity": 2 },
    { "product_id": 3, "quantity": 1 }
  ]
}
```

### Track order

```http
GET /api/orders/TK-20260101-ABCDE
```

The Flutter app should store the returned `order.order_number` after creating an order.
