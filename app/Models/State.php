<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class State extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    protected $fillable  = ['name'];

    public $translatable = ['name'];

    protected $casts = [
        'name' => 'string',
    ];

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function toArray()
    {
        $attributes = parent::toArray();
        foreach ($this->getTranslatableAttributes() as $field) {
            $attributes[$field] = $this->getTranslation($field, app()->getLocale());
        }
        return $attributes;
    }

}
