<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'image_path',
        'description',
        'category',
        'is_available',
        'discount_percentage',
        'discount_expires_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
        'discount_expires_at' => 'datetime',
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the full image URL for the product.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (empty($this->image_path)) {
            return null;
        }

        // If it starts with 'images/' it's in published assets
        if (str_starts_with($this->image_path, 'images/')) {
            return asset($this->image_path);
        }

        // Otherwise it's a Filament upload in storage
        return asset('storage/' . $this->image_path);
    }

    /**
     * Check if this product is currently on flash sale.
     */
    public function isOnFlashSale(): bool
    {
        return $this->discount_percentage > 0
            && $this->discount_expires_at
            && $this->discount_expires_at->isFuture();
    }

    /**
     * Get the effective price after discount.
     */
    public function getEffectivePriceAttribute(): float
    {
        if ($this->isOnFlashSale()) {
            return round($this->price * (1 - $this->discount_percentage / 100), 2);
        }
        return $this->price;
    }
}
