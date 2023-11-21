<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Category extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, HasTranslations, InteractsWithMedia;

    protected $fillable  = ['name'];

    public $translatable = ['name'];

    protected $casts = [
        'name' => 'string',
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function getImageAttribute()
    {
        if ($this->getMedia('image')->first())
            return $this->getMedia('image')->first()->getFullUrl();
        return null;
    }

    protected $appends = ['image'];

    public function toArray()
    {
        $attributes = parent::toArray();
        foreach ($this->getTranslatableAttributes() as $field) {
            $attributes[$field] = $this->getTranslation($field, app()->getLocale());
        }
        return $attributes;
    }

}
