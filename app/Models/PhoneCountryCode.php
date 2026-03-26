<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneCountryCode extends Model
{
    protected $primaryKey = 'code';
    protected $keyType    = 'string';
    public    $incrementing = false;

    protected $fillable = [
        'code',
        'name',
        'native_name',
        'phone_code',
        'trunk_prefix',
        'idd_prefix',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ── Scopes ─────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // ── Helpers ────────────────────────────────────────────────

    /** Display label used in select dropdowns: "+994 (AZ)" */
    public function getDisplayLabelAttribute(): string
    {
        return "{$this->phone_code} ({$this->code}) {$this->name}";
    }
}
