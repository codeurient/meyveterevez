<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreProfile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'name', 'slug', 'description', 'logo', 'banner',
        'location_id', 'address', 'phone', 'whatsapp', 'email', 'website',
        'rating_avg', 'rating_count', 'product_count', 'sale_count',
        'is_verified', 'is_active', 'approved_at',
        'return_policy', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'rating_avg'   => 'decimal:2',
        'is_verified'  => 'boolean',
        'is_active'    => 'boolean',
        'approved_at'  => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('store_profiles.is_active', true);
    }

    public function scopeVerified(Builder $query): Builder
    {
        return $query->where('store_profiles.is_verified', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
