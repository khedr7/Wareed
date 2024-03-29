<?php

namespace App\Models;

use Codebyray\ReviewRateable\Contracts\ReviewRateable;
use Codebyray\ReviewRateable\Models\Rating;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Traits\HasRoles;
use Codebyray\ReviewRateable\Traits\ReviewRateable as ReviewRateableTrait;

class User extends Authenticatable implements HasMedia, ReviewRateable
{
    use HasApiTokens, HasFactory, Notifiable;
    use InteractsWithMedia, HasRoles, ReviewRateableTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'address', 'phone', 'role', 'details', 'points', 'enable_notification',
        'latitude', 'longitude', 'status', 'gender', 'birthday', 'fcm_token', 'city_id', 'accepted', 'app_lang',
        'enable_cash'
    ];
    const PATH = 'users';
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at'   => 'datetime',
        'status'              => 'integer',
        'accepted'            => 'integer',
        'enable_notification' => 'integer',
        'enable_cash'         => 'integer',
        'city_id'             => 'integer',
        'points'              => 'double',
        'latitude'            => 'double',
        'longitude'           => 'double',
        'birthday'            => 'date',
    ];

    public function getProfileAttribute()
    {
        if ($this->getMedia('profile')->first())
            return $this->getMedia('profile')->first()->getFullUrl();
        return null;
    }

    protected $appends = ['profile'];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function providerOrders()
    {
        return $this->hasMany(Order::class, 'provider_id');
    }

    public function replies()
    {
        return $this->hasMany(ComplaintReply::class);
    }

    // many to many
    public function days()
    {
        return $this->belongsToMany(Day::class, 'day_user', 'user_id', 'day_id');
    }

    // many to many
    public function requests()
    {
        return $this->hasMany(ServiceRequest::class);
    }

    // many to many
    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_user', 'user_id', 'service_id')
            ->withPivot(['on_patient_site', 'on_provider_site']);
    }

    // many to many
    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'notification_user', 'user_id', 'notification_id')
            ->orderBy('created_at', 'desc')->withPivot(['seen', 'seen_at']);
    }

    public function userRating()
    {
        return $this->morphMany(Rating::class, 'reviewrateable');
    }

    public function userAppRating()
    {
        return $this->morphMany(Rating::class, 'reviewrateable')->where('approved', true);
    }

    public function scopeApp($query)
    {

        $newQuery = $query
            ->when(request()->status == 1, function ($query) {
                return $query->where('status', 1);
            })
            ->when(request()->accepted == 1, function ($query) {
                return $query->where('accepted', 1);
            })
            ->when(request()->category_id, function ($query) {
                return $query->whereHas('services', function ($query) {
                    $query->where('category_id', request()->category_id)->where('status', 1);
                });
            })
            ->when(request()->date, function ($query) {
                return $query->whereHas('days', function ($query) {
                    $query->Where("name", 'like', '%' . Carbon::parse(request()->date)->dayName . '%');
                });
            })
            ->when(request()->city_id, function ($query) {
                return $query->where('city_id', request()->city_id);
            })
            ->when(request()->service_id, function ($query) {
                return $query->whereHas('services', function ($query) {
                    $query->where('services.id', request()->service_id);
                });
            })
            ->when(request()->gender, function ($query) {
                return $query->where('gender', request()->gender);
            })
            ->when(request()->search, function ($query) {
                return $query->Where("name", 'like', '%' . request()->search . '%')
                    ->orWhereHas('services', function ($query) {
                        $query->where(DB::raw("lower(services.name)"), 'like', '%' . strtolower(request()->search) . '%')
                            ->orWhere("services.name->ar", 'like', '%' . request()->search . '%')
                            ->orWhere(DB::raw("lower(services.details)"), 'like', '%' . strtolower(request()->search) . '%')
                            ->orWhere("services.details->ar", 'like', '%' . request()->search . '%')
                            ->orWhereHas('keywords', function ($query) {
                                $query->where('service_key_words.key', 'like', '%' . request()->search . '%');
                            });
                    });
            })
            ->when(isset(request()->sort_by_name), function ($query) {
                $sortOrder = request()->sort_by_name == '1' ? 'ASC' : 'DESC';
                return $query->orderBy('name', $sortOrder);
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
