<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    use InteractsWithMedia, HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'address', 'phone', 'role', 'details',
        'status', 'has_residence', 'gender', 'birthday', 'fcm_token', 'city_id'
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
        'email_verified_at' => 'datetime',
        'status'            => 'integer',
        'has_residence'     => 'integer',
        'city_id'           => 'integer',
        'birthday'          => 'date',
    ];

    public function getProfileAttribute()
    {
        if ($this->getMedia('profile')->first())
            return $this->getMedia('profile')->first()->getFullUrl();
        return null;
    }

    protected $appends = ['profile'];

    public function userCity()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
