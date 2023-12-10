<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintReply extends Model
{
    use HasFactory;

    protected $fillable  = ['details', 'user_id', 'complaint_id'];

    protected $casts = [
        'user_id'         => 'integer',
        'complaint_id_id' => 'integer',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function complaint()
    {
        return $this->belongsTo(Complaint::class, 'complaint_id', 'id');
    }
}
