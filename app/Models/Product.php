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
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
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
        if (! $this->image_path) {
            return null;
        }

        // If it starts with 'images/' it's in published assets
        if (str_starts_with($this->image_path, 'images/')) {
            return asset($this->image_path);
        }

        // Otherwise it's a Filament upload in storage
        return asset('storage/' . $this->image_path);
    }
}
