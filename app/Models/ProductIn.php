<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductIn extends Model
{
    use HasFactory;

    protected $table = 'product_in';
    
    protected $fillable = [
        'supplier_id',
        'product_id',
        'purchase_price',
        'quantity',
    ];

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
