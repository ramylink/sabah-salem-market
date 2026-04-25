<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'variant_id',
        'quantity',
        'unit_price',
        'total_price',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:3',
        'total_price' => 'decimal:3',
    ];

    protected $appends = ['formatted_total', 'product_name', 'product_image'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            $item->unit_price = $item->variant_id 
                ? $item->variant->final_price 
                : $item->product->price;
            $item->total_price = $item->unit_price * $item->quantity;
        });
    }

    public function getFormattedTotalAttribute(): string
    {
        return number_format($this->total_price, 3) . ' د.ك';
    }

    public function getProductNameAttribute(): string
    {
        return $this->product->name;
    }

    public function getProductImageAttribute(): string
    {
        return $this->variant_id 
            ? $this->variant->image_url 
            : $this->product->featured_image_url;
    }
}
