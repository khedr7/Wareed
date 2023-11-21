<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable  = ['name', 'status'];

    protected $casts = [
        'name'   => 'string',
        'status' => 'integer',
    ];

    // public function orders()
    // {
    //     return $this->hasMany(Order::class);
    // }

}
