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
        'price',
        'discount',
    ];

    public function category() {
        return $this->belongsTo(ProductCategory::class);
    }
}
