<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'password',
        'avatar',
        'nik',
        'name',
        'born_place',
        'born_date',
        'gender',
        'address',
        'blood_type',
        'religion',
        'is_married',
        'profession',
        'ktp',
    ];
}
