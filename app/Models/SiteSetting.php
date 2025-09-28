<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_title',
        'logo',
        'favicon',
        'hero_image',
        'site_phone_number',
        'site_email',
        'copyright_text',
    ];



    // Accessor for Logo URL
    public function getLogoUrlAttribute()
    {
        return $this->logo
            ? Storage::url("image/settings/logo.{$this->logo}")
            : asset('assets/img/default-image.jpg');
    }

    // Accessor for Favicon URL
    public function getFaviconUrlAttribute()
    {
        return $this->favicon
            ? Storage::url("image/settings/favicon.{$this->favicon}")
            : asset('assets/img/default-image.jpg');
    }

    // Accessor for Hero Image URL
    public function getHeroImageUrlAttribute()
    {
        return $this->hero_image
            ? Storage::url("image/settings/hero.{$this->hero_image}")
            : asset('assets/img/default-image.jpg');
    }
}
