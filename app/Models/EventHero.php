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


    // Accessor for hero image URL
    public function getHeroUrlAttribute()
    {
        return $this->hero_image
            ? Storage::url("image/event/event-hero.{$this->hero_image}")
            : asset('images/default-logo.png');
    }
}
