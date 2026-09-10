<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class PlatformSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'display_name',
        'description',
    ];

    /**
     * Get a setting value by key with a default fallback.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        try {
            if (!Schema::hasTable('platform_settings')) {
                return $default;
            }

            return Cache::remember("platform_setting_{$key}", 3600, function () use ($key, $default) {
                $setting = self::where('key', $key)->first();
                if (!$setting) {
                    return $default;
                }

                return self::castValue($setting->value, $setting->type);
            });
        } catch (\Throwable) {
            return $default;
        }
    }

    /**
     * Set/update a setting value by key.
     */
    public static function set(string $key, mixed $value, string $type = 'string', array $metadata = []): self
    {
        $serializedValue = is_array($value) ? json_encode($value) : (string) $value;

        $setting = self::updateOrCreate(
            ['key' => $key],
            array_merge([
                'value' => $serializedValue,
                'type' => $type,
            ], $metadata)
        );

        Cache::forget("platform_setting_{$key}");

        return $setting;
    }

    /**
     * Cast raw value based on type.
     */
    protected static function castValue(?string $value, string $type): mixed
    {
        if ($value === null) {
            return null;
        }

        return match ($type) {
            'decimal', 'float' => (float) $value,
            'integer', 'int' => (int) $value,
            'boolean', 'bool' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'json', 'array' => json_decode($value, true) ?: [],
            default => $value,
        };
    }
}
