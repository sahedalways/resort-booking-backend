<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FeatureImage extends Model
{
    protected $fillable = [
        'resort_image',
        'event_image',
    ];
    protected $appends = ['resortImageUrl', 'eventImageUrl'];


    public function getResortImageUrlAttribute()
    {
        return $this->resort_image
            ? Storage::url("image/content/features/resort_image.{$this->resort_image}")
            : asset('assets/img/default-image.jpg');
    }


    public function getEventImageUrlAttribute()
    {
        return $this->event_image
            ? Storage::url("image/content/features/event_image.{$this->event_image}")
            : asset('assets/img/default-image.jpg');
    }
}
