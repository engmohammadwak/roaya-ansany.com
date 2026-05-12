<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model {
    protected $fillable = ['first_name','last_name','email','phone','message','is_read'];
    protected $casts    = ['is_read' => 'boolean'];

    public function getFullNameAttribute(): string {
        return trim($this->first_name . ' ' . $this->last_name);
    }
}
