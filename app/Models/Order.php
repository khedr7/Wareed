<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable  = [
        'user_id', 'service_id', 'payment_method_id',
        'status', 'payment_status', 'date', 'note',
    ];

    protected $casts = [
        'user_id'           => 'integer',
        'service_id'       => 'integer',
        'payment_method_id' => 'integer',
        'status'            => 'string',
        'payment_status'    => 'integer',
        'date'              => 'dateTime',
        'note'              => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }
}
