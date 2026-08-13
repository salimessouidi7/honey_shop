<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = [
        'key',
        'name',
        'description',
        'enabled',
        'license_key',
        'license_status',
        'license_expires_at',
    ];

    protected $casts = [
        'enabled'             => 'boolean',
        'license_expires_at'  => 'datetime',
    ];

    // The single source of truth for "is this feature on?" - used by the
    // 'feature' middleware, and can be called directly from controllers/views.
    // Today this just checks the 'enabled' flag; when a real license-key system
    // is added later, the extra checks (license_status, expiry) slot in right here
    // without any caller needing to change.
    public static function enabled(string $key): bool
    {
        return static::query()->where('key', $key)->value('enabled') ?? false;
    }
}
