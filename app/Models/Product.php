<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'sku',
        'barcode',
        'price',
        'compare_price',
        'cost',
        'stock_quantity',
        'stock_status',
        'weight',
        'unit',
        'category_id',
        'brand_id',
        'images',
        'featured_image',
        'is_active',
        'is_featured',
        'is_new',
        'is_on_sale',
        'tax_rate',
        'min_order_quantity',
        'max_order_quantity',
        'meta_title',
        'meta_description',
        'tags',
        'nutritional_info',
        'allergens',
        'expiry_date',
    ];

    protected $casts = [
        'price' => 'decimal:3',
        'compare_price' => 'decimal:3',
        'cost' => 'decimal:3',
        'weight' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_new' => 'boolean',
        'is_on_sale' => 'boolean',
        'images' => 'array',
        'nutritional_info' => 'array',
        'allergens' => 'array',
        'expiry_date' => 'date',
        'min_order_quantity' => 'integer',
        'max_order_quantity' => 'integer',
    ];

    protected $appends = [
        'featured_image_url',
        'image_urls',
        'discount_percentage',
        'is_in_stock',
        'formatted_price',
        'formatted_compare_price',
        'savings_amount',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function relatedProducts(): BelongsToMany
    {
        return $this->belongsToMany(
            self::class,
            'related_products',
            'product_id',
            'related_product_id'
        );
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeOnSale(Builder $query): Builder
    {
        return $query->where('is_on_sale', true)
            ->whereNotNull('compare_price')
            ->whereColumn('compare_price', '>', 'price');
    }

    public function scopeInStock(Builder $query): Builder
    {
        return $query->where('stock_status', 'in_stock')
            ->where('stock_quantity', '>', 0);
    }

    public function scopeNewArrivals(Builder $query): Builder
    {
        return $query->where('is_new', true)
            ->where('created_at', '>=', now()->subDays(30));
    }

    public function scopePopular(Builder $query): Builder
    {
        return $query->withCount('orderItems')
            ->orderBy('order_items_count', 'desc');
    }

    public function scopeSearch(Builder $query, string $term): Builder
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('description', 'like', "%{$term}%")
              ->orWhere('sku', 'like', "%{$term}%")
              ->orWhere('barcode', 'like', "%{$term}%")
              ->orWhereHas('category', function ($cq) use ($term) {
                  $cq->where('name', 'like', "%{$term}%");
              })
              ->orWhereHas('brand', function ($bq) use ($term) {
                  $bq->where('name', 'like', "%{$term}%");
              });
        });
    }

    public function scopePriceRange(Builder $query, float $min, float $max): Builder
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    // Accessors
    public function getFeaturedImageUrlAttribute(): string
    {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }
        if (!empty($this->images) && is_array($this->images)) {
            return asset('storage/' . $this->images[0]);
        }
        return asset('images/default-product.svg');
    }

    public function getImageUrlsAttribute(): array
    {
        $urls = [];
        if (!empty($this->images) && is_array($this->images)) {
            foreach ($this->images as $image) {
                $urls[] = asset('storage/' . $image);
            }
        }
        if (empty($urls)) {
            $urls[] = asset('images/default-product.svg');
        }
        return $urls;
    }

    public function getDiscountPercentageAttribute(): ?int
    {
        if ($this->compare_price && $this->compare_price > $this->price) {
            return (int) round((($this->compare_price - $this->price) / $this->compare_price) * 100);
        }
        return null;
    }

    public function getIsInStockAttribute(): bool
    {
        return $this->stock_status === 'in_stock' && $this->stock_quantity > 0;
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 3) . ' د.ك';
    }

    public function getFormattedComparePriceAttribute(): ?string
    {
        return $this->compare_price ? number_format($this->compare_price, 3) . ' د.ك' : null;
    }

    public function getSavingsAmountAttribute(): ?string
    {
        if ($this->compare_price && $this->compare_price > $this->price) {
            return number_format($this->compare_price - $this->price, 3) . ' د.ك';
        }
        return null;
    }

    public function getAverageRatingAttribute(): float
    {
        return Cache::remember("product:{$this->id}:rating", 3600, function () {
            return round($this->reviews()->avg('rating') ?? 0, 1);
        });
    }

    public function getReviewsCountAttribute(): int
    {
        return Cache::remember("product:{$this->id}:reviews_count", 3600, function () {
            return $this->reviews()->count();
        });
    }

    // Methods
    public function decrementStock(int $quantity = 1): void
    {
        $this->decrement('stock_quantity', $quantity);

        if ($this->stock_quantity <= $this->min_order_quantity) {
            $this->update(['stock_status' => 'low_stock']);
        }

        if ($this->stock_quantity <= 0) {
            $this->update(['stock_status' => 'out_of_stock']);
        }

        Cache::forget("product:{$this->id}:*");
    }

    public function incrementStock(int $quantity = 1): void
    {
        $this->increment('stock_quantity', $quantity);

        if ($this->stock_quantity > 0) {
            $this->update(['stock_status' => 'in_stock']);
        }

        Cache::forget("product:{$this->id}:*");
    }

    // Boot
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($product) {
            Cache::tags(['products'])->flush();
        });

        static::deleted(function ($product) {
            Cache::tags(['products'])->flush();
        });
    }
}
