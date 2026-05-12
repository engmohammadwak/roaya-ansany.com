<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymobSetting extends Model
{
    protected $fillable = [
        'api_key',
        'integration_id',
        'iframe_id',
        'hmac_secret',
        'base_url',
        'is_active',
        'test_mode',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'test_mode'  => 'boolean',
    ];

    public static function current(): self
    {
        return static::firstOrNew(['id' => 1]);
    }
}
