<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 
        'slug', 
        'description'
    ];

    // 1 Brand có nhiều Product
    public function products() {
        return $this->hasMany(Product::class);
    }
}
