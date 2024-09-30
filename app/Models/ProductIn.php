<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductIn extends Model
{
    use HasFactory;

    protected $table = 'product_in';
    
    protected $fillable = [
        'product_id',
        'purchase_price',
        'quantity',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
