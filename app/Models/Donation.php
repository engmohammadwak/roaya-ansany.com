<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'campaign_id',
        'name',          // donor name
        'email',
        'phone',
        'amount',
        'currency',
        'payment_method',
        'transaction_id',
        'status',
        'message',
        'is_anonymous',
        // extra fields added via migration
        'card_brand',
        'description',
        'gateway_ref',
        'gateway_data',
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'is_anonymous' => 'boolean',
        'gateway_data' => 'array',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    // Aliases for Filament display
    public function getDonorNameAttribute(): string
    {
        return $this->name ?? '';
    }
    public function getDonorEmailAttribute(): string
    {
        return $this->email ?? '';
    }
}
