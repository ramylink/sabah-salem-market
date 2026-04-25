<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'sku',
        'price_adjustment',
        'stock_quantity',
        'stock_status',
        'image',
        'is_default',
        'sort_order',
    ];

    protected $casts = [
        'price_adjustment' => 'decimal:3',
        'is_default' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected $appends = ['final_price', 'image_url'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getFinalPriceAttribute(): float
    {
        return $this->product->price + $this->price_adjustment;
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image 
            ? asset('storage/' . $this->image) 
            : $this->product->featured_image_url;
    }

    public function scopeActive($query)
    {
        return $query->whereHas('product', function ($q) {
            $q->where('is_active', true);
        });
    }
}
