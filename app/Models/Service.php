<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Service extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable  = [
        'name', 'details', 'price', 'latitude',
        'longitude', 'status', 'featured', 'category_id', 'user_id',
    ];

    // public $translatable = ['name', 'details'];

    protected $casts = [
        'price'       => 'float',
        'latitude'    => 'float',
        'longitude'   => 'float',
        'status'      => 'integer',
        'featured'    => 'integer',
        'user_id'     => 'integer',
        'category_id' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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
}
