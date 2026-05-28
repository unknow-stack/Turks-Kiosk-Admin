<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'sku',
        'slug',
        'description',
        'price',
        'image_path',
        'image_url',
        'is_available',
        'is_featured',
        'stock_status',
        'display_order',
    ];

    protected $appends = [
        'display_image',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_available' => 'boolean',
            'is_featured' => 'boolean',
            'display_order' => 'integer',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getDisplayImageAttribute(): string
    {
        if ($this->image_path) {
            return Storage::url($this->image_path);
        }

        if ($this->image_url) {
            return $this->image_url;
        }

        return asset('assets/images/turks-lifestyle.jpg');
    }
}
