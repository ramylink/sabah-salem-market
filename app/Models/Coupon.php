<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'min_order_amount',
        'max_discount_amount',
        'usage_limit',
        'usage_limit_per_user',
        'used_count',
        'starts_at',
        'expires_at',
        'is_active',
        'applies_to',
        'category_ids',
        'product_ids',
        'exclude_product_ids',
    ];

    protected $casts = [
        'value' => 'decimal:3',
        'min_order_amount' => 'decimal:3',
        'max_discount_amount' => 'decimal:3',
        'usage_limit' => 'integer',
        'usage_limit_per_user' => 'integer',
        'used_count' => 'integer',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'category_ids' => 'array',
        'product_ids' => 'array',
        'exclude_product_ids' => 'array',
    ];

    public const TYPE_PERCENTAGE = 'percentage';
    public const TYPE_FIXED = 'fixed';
    public const TYPE_FREE_SHIPPING = 'free_shipping';

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')
                  ->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>=', now());
            });
    }

    public function scopeValid($query)
    {
        return $query->active()
            ->where(function ($q) {
                $q->whereNull('usage_limit')
                  ->orWhereColumn('used_count', '<', 'usage_limit');
            });
    }

    public function isValid(): bool
    {
        if (!$this->is_active) return false;
        if ($this->starts_at && $this->starts_at->isFuture()) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;
        return true;
    }

    public function calculateDiscount(float $subtotal): float
    {
        if (!$this->isValid()) return 0;
        if ($this->min_order_amount && $subtotal < $this->min_order_amount) return 0;

        $discount = match($this->type) {
            self::TYPE_PERCENTAGE => $subtotal * ($this->value / 100),
            self::TYPE_FIXED => min($this->value, $subtotal),
            self::TYPE_FREE_SHIPPING => 0,
            default => 0,
        };

        if ($this->max_discount_amount) {
            $discount = min($discount, $this->max_discount_amount);
        }

        return round($discount, 3);
    }

    public function canBeUsedBy(User $user): bool
    {
        if ($this->usage_limit_per_user) {
            $userUsage = $this->orders()
                ->where('user_id', $user->id)
                ->count();
            if ($userUsage >= $this->usage_limit_per_user) return false;
        }
        return true;
    }
}
