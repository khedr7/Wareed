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
        'status', 'payment_status', 'date', 'note','patients_number',
        'end_date','provider_id','on_provider_site','on_patient_site'
    ];

    protected $casts = [
        'user_id'           => 'integer',
        'service_id'        => 'integer',
        'payment_method_id' => 'integer',
        'status'            => 'string',
        'payment_status'    => 'integer',
        'date'              => 'datetime',
        'note'              => 'string',
        'patients_number'   => 'integer',
        'end_date'          => 'datetime',
        'provider_id'       => 'integer',
        'on_provider_site'  => 'boolean',
        'on_patient_site'   => 'boolean',

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }

    public function scopeApp($query)
    {

        $newQuery = $query
            ->when(request()->has('status'), function ($query) {
                return $query->where('status', request()->status);
            });

        return $newQuery->get();
    }
}
