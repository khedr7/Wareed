<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class City extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    protected $fillable  = ['name', 'state_id'];

    public $translatable = ['name'];

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
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
