<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'label',
        'area',
        'block',
        'street',
        'building',
        'floor',
        'apartment',
        'phone',
        'notes',
        'is_default',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    protected $appends = ['full_address'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->area,
            $this->block ? 'ق ' . $this->block : null,
            $this->street ? 'ش ' . $this->street : null,
            $this->building ? 'م ' . $this->building : null,
            $this->floor ? 'د ' . $this->floor : null,
            $this->apartment ? 'شقة ' . $this->apartment : null,
        ]);
        return implode('، ', $parts);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($address) {
            if ($address->is_default) {
                static::where('user_id', $address->user_id)
                    ->where('id', '!=', $address->id)
                    ->update(['is_default' => false]);
            }
        });
    }
}
