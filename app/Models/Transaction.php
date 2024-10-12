<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_invoice',
        'created_by',
        'transaction_discount',
        'total',
        'cash',
        'change',
        'notes',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }
}
