<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $fillable  = [
        'title', 'details', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(user::class, 'user_id', 'id');
    }
}
