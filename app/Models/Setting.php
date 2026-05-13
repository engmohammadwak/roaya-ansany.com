<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get($key, $default = null)
    {
        // لا نستخدم rememberForever لأنه يسبب مشاكل مع بعض drivers
        $cached = Cache::get('setting_' . $key);
        if ($cached !== null) {
            return $cached;
        }
        $setting = static::where('key', $key)->first();
        $value   = $setting ? $setting->value : $default;
        if ($value !== null) {
            Cache::put('setting_' . $key, $value, now()->addHours(6));
        }
        return $value;
    }

    public static function set($key, $value)
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('setting_' . $key);
        Cache::forget('all_settings');
    }

    public static function getAllSettings()
    {
        $cached = Cache::get('all_settings');
        if ($cached !== null) {
            return $cached;
        }
        $settings = static::all()->pluck('value', 'key');
        Cache::put('all_settings', $settings, now()->addHours(6));
        return $settings;
    }
}
