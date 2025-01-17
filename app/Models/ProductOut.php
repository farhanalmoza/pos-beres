<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOut extends Model
{
    use HasFactory;

    protected $table = 'product_out';
    
    protected $fillable = [
        'store_id',
        'product_id',
        'quantity',
        'total_price',
        'ppn',
    ];

    public function store() {
        return $this->belongsTo(Store::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
