<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Service extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable  = [
        'name', 'details', 'price', 'latitude', 'on_patient_site',
        'longitude', 'status', 'featured', 'category_id',
    ];
    const PATH = 'services';

    // public $translatable = ['name', 'details'];

    protected $casts = [
        'price'       => 'double',
        'latitude'    => 'double',
        'longitude'   => 'double',
        'status'      => 'integer',
        'featured'    => 'integer',
        'category_id' => 'integer',
        'on_patient_site'   => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    // many to many
    public function users()
    {
        return $this->belongsToMany(User::class, 'service_user', 'service_id', 'user_id')
            ->withPivot(['on_patient_site', 'on_provider_site']);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getImageAttribute()
    {
        if ($this->getMedia('image')->first())
            return $this->getMedia('image')->first()->getFullUrl();
        return null;
    }

    protected $appends = ['image'];


    // public function toArray()
    // {
    //     $attributes = parent::toArray();
    //     foreach ($this->getTranslatableAttributes() as $field) {
    //         $attributes[$field] = $this->getTranslation($field, app()->getLocale());
    //     }
    //     return $attributes;
    // }

    public function scopeApp($query)
    {
        $user = Auth::guard('user')->user();
        if (!$user) {
            $newQuery = $query;
        } elseif ($user->role == "admin") {
            $newQuery = $query;
        } elseif ($user->role == "user") {
            $newQuery = $query;
        } else {
            $newQuery = $query->whereIn('id', $user->services->pluck('id'));
        }

        $newQuery = $newQuery
            ->when(request()->status == 1, function ($query) {
                return $query->where('status', 1);
            })
            ->when(request()->featured == 1, function ($query) {
                return $query->where('featured', 1);
            })
            ->when(request()->category_id, function ($query) {
                return $query->where('category_id', request()->category_id);
            })
            ->when(request()->user_id, function ($query) {
                return $query->where('user_id', request()->user_id);
            })
            ->when(request()->min_price || request()->max_price, function ($query) {
                return $query->whereBetween('price', [request()->min_price, request()->max_price]);
            })
            ->when(request()->search, function ($query) {
                return $query->where(DB::raw("lower(name)"), 'like', '%' . strtolower(request()->search) . '%')
                    ->orWhere("name->ar", 'like', '%' . request()->search . '%');
            })
            ->when(isset(request()->sort_by_name), function ($query) {
                $sortOrder = request()->sort_by_name == '1' ? 'ASC' : 'DESC';
                return $query->orderBy('name', $sortOrder, request()->lang);
            })
            ->when(isset(request()->recent), function ($query) {
                $sortOrder = request()->recent == '1' ? 'ASC' : 'DESC';
                return $query->orderBy('created_at', $sortOrder);
            });

        if (request()->latitude != null && request()->longitude != null) {
            $latitude  = request()->latitude;
            $longitude = request()->longitude;
            $radius    = 5;
            $newQuery->whereRaw('ST_Distance(point(map_lat, map_lng), point(?, ?)) <= ?', [$longitude, $latitude, $radius * 1000]);
        }

        if (request()->skip_count != null && request()->max_count != null) {
            $skipCount = request()->skip_count;
            $maxCount  = request()->max_count;
            $newQuery  = $newQuery->skip($skipCount)->take($maxCount);
        }

        return $newQuery->get();
    }
}
