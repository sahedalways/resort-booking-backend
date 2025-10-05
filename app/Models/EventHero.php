<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EventHero extends Model
{
    protected $fillable = [
        'title',
        'sub_title',
        'hero_image',
        'phone_number',
    ];

    protected $appends = ['hero_url'];

    // Accessor for hero image URL
    public function getHeroUrlAttribute()
    {
        return $this->hero_image
            ? getFileUrlForFrontend("image/event/event-hero.{$this->hero_image}")
            : asset('assets/img/default-image.jpg');
    }
}
