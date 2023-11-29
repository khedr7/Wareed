<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Banner extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable  = ['link', 'start_date', 'expiration_date', 'status'];

    protected $casts = [
        'link'            => 'string',
        'start_date'      => 'date',
        'expiration_date' => 'date',
        'status'          => 'integer',
    ];

    const PATH = 'banners';

    public function getImageAttribute()
    {
        if ($this->getMedia('image')->first())
            return $this->getMedia('image')->first()->getFullUrl();
        return null;
    }

    protected $appends = ['image'];
}
