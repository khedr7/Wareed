<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Notification extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable  = ['title', 'body', 'by_admin', 'to_type', 'service_type', 'service_id'];

    public $translatable = ['title', 'body'];

    protected $casts = [
        'title'        => 'string',
        'body'         => 'string',
        'by_admin'     => 'integer',
        'to_type'      => 'string',
        'service_type' => 'string',
        'service_id'   => 'integer',
    ];

    public function toArray()
    {
        $attributes = parent::toArray();
        foreach ($this->getTranslatableAttributes() as $field) {
            $attributes[$field] = $this->getTranslation($field, app()->getLocale());
        }
        return $attributes;
    }

    // many to many
    public function users()
    {
        return $this->belongsToMany(User::class, 'notification_user', 'notification_id', 'user_id');
    }
}
