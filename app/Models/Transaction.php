<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_invoice',
        'store_id',
        'created_by',
        'transaction_discount',
        'total',
        'cash',
        'change',
        'notes',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'no_invoice', 'no_invoice');
    }
}
