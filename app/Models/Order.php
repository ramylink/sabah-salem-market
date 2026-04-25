<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'status',
        'payment_status',
        'payment_method',
        'payment_reference',
        'subtotal',
        'discount_amount',
        'tax_amount',
        'delivery_fee',
        'total',
        'coupon_id',
        'coupon_code',
        'notes',
        'delivery_address',
        'delivery_area',
        'delivery_block',
        'delivery_street',
        'delivery_building',
        'delivery_floor',
        'delivery_apartment',
        'delivery_phone',
        'delivery_instructions',
        'scheduled_delivery_date',
        'scheduled_delivery_time',
        'delivered_at',
        'cancelled_at',
        'cancellation_reason',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'subtotal' => 'decimal:3',
        'discount_amount' => 'decimal:3',
        'tax_amount' => 'decimal:3',
        'delivery_fee' => 'decimal:3',
        'total' => 'decimal:3',
        'scheduled_delivery_date' => 'date',
        'scheduled_delivery_time' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    protected $appends = ['formatted_total', 'status_label', 'status_color'];

    public const STATUS_NEW = 'new';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_PACKING = 'packing';
    public const STATUS_SHIPPED = 'shipped';
    public const STATUS_DELIVERED = 'delivered';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_REFUNDED = 'refunded';

    public const PAYMENT_PENDING = 'pending';
    public const PAYMENT_PAID = 'paid';
    public const PAYMENT_FAILED = 'failed';
    public const PAYMENT_REFUNDED = 'refunded';

    public static function statuses(): array
    {
        return [
            self::STATUS_NEW => 'جديد',
            self::STATUS_CONFIRMED => 'مؤكد',
            self::STATUS_PROCESSING => 'قيد التجهيز',
            self::STATUS_PACKING => 'قيد التغليف',
            self::STATUS_SHIPPED => 'تم الشحن',
            self::STATUS_DELIVERED => 'تم التسليم',
            self::STATUS_CANCELLED => 'ملغي',
            self::STATUS_REFUNDED => 'مسترجع',
        ];
    }

    public static function paymentStatuses(): array
    {
        return [
            self::PAYMENT_PENDING => 'معلق',
            self::PAYMENT_PAID => 'مدفوع',
            self::PAYMENT_FAILED => 'فشل',
            self::PAYMENT_REFUNDED => 'مسترجع',
        ];
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class)->orderBy('created_at');
    }

    // Scopes
    public function scopeNew($query)
    {
        return $query->where('status', self::STATUS_NEW);
    }

    public function scopeActive($query)
    {
        return $query->whereNotIn('status', [self::STATUS_DELIVERED, self::STATUS_CANCELLED, self::STATUS_REFUNDED]);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_NEW);
    }

    public function scopeProcessing($query)
    {
        return $query->whereIn('status', [self::STATUS_CONFIRMED, self::STATUS_PROCESSING, self::STATUS_PACKING]);
    }

    public function scopeShipped($query)
    {
        return $query->where('status', self::STATUS_SHIPPED);
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', self::STATUS_DELIVERED);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', self::STATUS_CANCELLED);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);
    }

    // Accessors
    public function getFormattedTotalAttribute(): string
    {
        return number_format($this->total, 3) . ' د.ك';
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statuses()[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_NEW => 'blue',
            self::STATUS_CONFIRMED => 'indigo',
            self::STATUS_PROCESSING => 'yellow',
            self::STATUS_PACKING => 'orange',
            self::STATUS_SHIPPED => 'purple',
            self::STATUS_DELIVERED => 'green',
            self::STATUS_CANCELLED => 'red',
            self::STATUS_REFUNDED => 'gray',
            default => 'gray',
        };
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return self::paymentStatuses()[$this->payment_status] ?? $this->payment_status;
    }

    public function getItemsCountAttribute(): int
    {
        return $this->items->sum('quantity');
    }

    // Methods
    public function updateStatus(string $status, ?string $notes = null): void
    {
        $oldStatus = $this->status;
        $this->update(['status' => $status]);

        $this->statusHistory()->create([
            'old_status' => $oldStatus,
            'new_status' => $status,
            'notes' => $notes,
            'changed_by' => auth()->id(),
        ]);
    }

    public function canCancel(): bool
    {
        return in_array($this->status, [self::STATUS_NEW, self::STATUS_CONFIRMED]);
    }

    public function canReorder(): bool
    {
        return in_array($this->status, [self::STATUS_DELIVERED, self::STATUS_CANCELLED]);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'SS-' . now()->format('Ymd') . '-' . strtoupper(uniqid());
            }
        });
    }
}
