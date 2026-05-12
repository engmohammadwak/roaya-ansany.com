<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get($key, $default = null)
    {
        return Cache::rememberForever('setting_' . $key, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public static function set($key, $value)
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('setting_' . $key);
        Cache::forget('all_settings');
    }

    public static function getAllSettings()
    {
        return Cache::rememberForever('all_settings', function () {
            return static::all()->pluck('value', 'key');
        });
    }
}
