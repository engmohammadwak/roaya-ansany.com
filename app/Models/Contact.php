<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model {
    protected $fillable = [
        'first_name', 'last_name',
        'name',   // kept for backward compat
        'email', 'phone', 'message', 'is_read',
    ];
    protected $casts = ['is_read' => 'boolean'];

    public function getFullNameAttribute(): string {
        if ($this->first_name) {
            return trim($this->first_name . ' ' . $this->last_name);
        }
        return $this->name ?? '';
    }
}
