<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PortfolioSetting extends Model
{
    protected $guarded = ['id'];

    public const CACHE_KEY = 'portfolio_settings';

    /** All settings as [key => value]. */
    public static function allAsArray(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return static::pluck('value', 'key')->toArray();
        });
    }

    public static function get(string $key, $default = null)
    {
        return static::allAsArray()[$key] ?? $default;
    }

    public static function put(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget(self::CACHE_KEY);
    }
}
