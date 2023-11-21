<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'otp'
    ];

    protected $cast = [
        'phone' => 'integer',
        'otp'   => 'integer',
    ];
}
