<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'avatar',
        'civil_id',
        'address',
        'area',
        'block',
        'street',
        'building',
        'floor',
        'apartment',
        'is_verified',
        'is_active',
        'last_login_at',
        'preferred_language',
        'notification_preferences',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
        'notification_preferences' => 'array',
    ];

    // Relationships
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class)->latest();
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function wishlist(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'wishlists')
            ->withTimestamps();
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function defaultAddress()
    {
        return $this->hasOne(Address::class)->where('is_default', true);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    // Accessors
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

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar 
            ? asset('storage/' . $this->avatar) 
            : asset('images/default-avatar.svg');
    }
}
