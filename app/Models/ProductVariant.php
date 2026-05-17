<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = ['product_id', 'image', 'description', 'price', 'sort_order'];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Effective image: variant image or fallback to product thumbnail.
     */
    public function getEffectiveImageAttribute(): ?string
    {
        return $this->image ?? $this->product?->thumbnail;
    }

    /**
     * Effective price: variant price or fallback to product price.
     */
    public function getEffectivePriceAttribute(): ?string
    {
        return $this->price ?? $this->product?->price;
    }

    /**
     * Effective description: variant description or fallback to product description.
     */
    public function getEffectiveDescriptionAttribute(): ?string
    {
        return $this->description ?? $this->product?->description;
    }
}
