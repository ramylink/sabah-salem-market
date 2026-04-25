<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'variant_id',
        'product_name',
        'product_sku',
        'product_image',
        'quantity',
        'unit_price',
        'total_price',
        'tax_amount',
        'discount_amount',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:3',
        'total_price' => 'decimal:3',
        'tax_amount' => 'decimal:3',
        'discount_amount' => 'decimal:3',
    ];

    protected $appends = ['formatted_total'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getFormattedTotalAttribute(): string
    {
        return number_format($this->total_price, 3) . ' د.ك';
    }
}
