<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'slug', 'price', 'description', 'thumbnail', 'status'];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'status' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            $product->slug = $product->slug ?: Str::slug($product->name);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class)->orderBy('sort_order');
    }

    /**
     * Starting price: lowest variant price, or product base price.
     */
    public function getStartingPriceAttribute()
    {
        $min = $this->variants->whereNotNull('price')->min('price');

        return $min ?? $this->price;
    }

    /**
     * Display image for cards: first variant image, or product thumbnail.
     */
    public function getDisplayImageAttribute(): ?string
    {
        return $this->variants->whereNotNull('image')->first()?->image
            ?? $this->images->first()?->image_url
            ?? $this->thumbnail;
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
