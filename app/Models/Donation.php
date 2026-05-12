<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'campaign_id', 'name', 'email',
        'phone', 'amount', 'currency',
        'payment_method', 'transaction_id',
        'status', 'message', 'is_anonymous'
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'is_anonymous' => 'boolean',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
