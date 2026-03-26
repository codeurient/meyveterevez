<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'store_profile_id', 'category_id',
        'name', 'slug', 'description',
        'price', 'original_price', 'discount_percent',
        'unit', 'weight_per_unit',
        'stock_quantity', 'in_stock', 'min_order_qty', 'max_order_qty',
        'is_organic', 'is_fresh_today', 'is_featured', 'is_top_seller',
        'rating_avg', 'rating_count', 'sale_count', 'views_count',
        'status', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'price'            => 'decimal:2',
        'original_price'   => 'decimal:2',
        'rating_avg'       => 'decimal:2',
        'in_stock'         => 'boolean',
        'is_organic'       => 'boolean',
        'is_fresh_today'   => 'boolean',
        'is_featured'      => 'boolean',
        'is_top_seller'    => 'boolean',
    ];

    // ==================== Relationships ====================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(StoreProfile::class, 'store_profile_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class)->where('is_approved', true);
    }

    // ==================== Scopes ====================

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true)->where('status', 'active');
    }

    public function scopeTopSellers(Builder $query): Builder
    {
        return $query->where('is_top_seller', true)->where('status', 'active');
    }

    public function scopeDiscounted(Builder $query): Builder
    {
        return $query->where('discount_percent', '>', 0)->where('status', 'active');
    }

    public function scopeInStock(Builder $query): Builder
    {
        return $query->where('in_stock', true);
    }

    public function scopeOrganic(Builder $query): Builder
    {
        return $query->where('is_organic', true);
    }

    public function scopeSearch(Builder $query, string $term): Builder
    {
        return $query->whereFullText(['name', 'description'], $term);
    }

    // ==================== Accessors ====================

    public function getImageUrlAttribute(): string
    {
        return $this->primaryImage?->image_path
            ? asset('storage/' . $this->primaryImage->image_path)
            : asset('images/placeholder-product.webp');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
