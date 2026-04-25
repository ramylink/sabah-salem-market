<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'icon',
        'parent_id',
        'sort_order',
        'is_active',
        'is_featured',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected $appends = ['image_url', 'product_count'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    // Relationships
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')
            ->orderBy('sort_order');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function allProducts(): HasMany
    {
        return $this->hasMany(Product::class)
            ->orWhereIn('category_id', function ($query) {
                $query->select('id')
                    ->from('categories')
                    ->where('parent_id', $this->id);
            });
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    // Accessors
    public function getImageUrlAttribute(): string
    {
        return $this->image 
            ? asset('storage/' . $this->image) 
            : asset('images/default-category.svg');
    }

    public function getProductCountAttribute(): int
    {
        return Cache::remember("category:{$this->id}:count", 3600, function () {
            return $this->products()->active()->count();
        });
    }

    // Boot
    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            Cache::tags(['categories'])->flush();
        });

        static::deleted(function () {
            Cache::tags(['categories'])->flush();
        });
    }
}
