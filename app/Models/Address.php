<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'full_name', 
        'phone', 
        'address_line',
        'city',
        'district',
        'ward',
        'is_default'
    ];

    // Nhiều địa chỉ thuộc 1 User
    public function user() {
        return $this->belongsTo(User::class);
    }

    // 1 địa chỉ có nhiều Order
    public function orders() {
        return $this->hasMany(Order::class);
    }
}
