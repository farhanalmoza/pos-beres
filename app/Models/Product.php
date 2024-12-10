<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'slug',
        'category_id',
        'quantity',
        'low_stock',
        'price',
        'warehouse_price',
        'discount',
    ];

    public function category() {
        return $this->belongsTo(ProductCategory::class);
    }

    public function carts() {
        return $this->hasMany(Cart::class);
    }
}
