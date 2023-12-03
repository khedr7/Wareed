<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Day extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable  = ['name'];

    public $translatable = ['name'];

    protected $casts = [
        'name'     => 'string',
    ];

    // many to many
    public function users()
    {
        return $this->belongsToMany(User::class, 'day_user', 'day_id', 'user_id');
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
