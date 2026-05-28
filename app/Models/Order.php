<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    public const STATUSES = ['pending', 'preparing', 'ready', 'completed', 'cancelled'];
    public const PAYMENT_STATUSES = ['unpaid', 'paid'];

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_contact',
        'order_type',
        'payment_method',
        'payment_status',
        'status',
        'subtotal_amount',
        'discount_amount',
        'total_amount',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'subtotal_amount' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
        ];
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber(): string
    {
        do {
            $number = 'TK-' . now()->format('Ymd') . '-' . Str::upper(Str::random(5));
        } while (static::where('order_number', $number)->exists());

        return $number;
    }

    public function statusLabel(): string
    {
        return str($this->status)->headline()->toString();
    }
}
