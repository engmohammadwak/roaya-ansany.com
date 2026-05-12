<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymobSetting extends Model
{
    protected $fillable = [
        'secret_key',
        'public_key',
        'integration_id',
        'hmac_secret',
        'base_url',
        'is_active',
        'test_mode',
        'callback_url',
        'redirect_url',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'test_mode' => 'boolean',
    ];

    public static function current(): self
    {
        return static::firstOrNew(['id' => 1]);
    }

    public function getBaseUrlAttribute($value): string
    {
        return rtrim($value ?? 'https://accept.paymob.com', '/');
    }
}
