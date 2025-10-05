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

    protected $appends = ['hero_image_url', 'favicon_url', 'logo_url'];

    // Accessor for logo_url
    public function getLogoUrlAttribute()
    {
        return $this->logo
            ? getFileUrlForFrontend('image/settings/logo.' . $this->logo)
            : asset('assets/img/default-image.jpg');
    }

    // Accessor for favicon_url
    public function getFaviconUrlAttribute()
    {
        return $this->favicon
            ? getFileUrlForFrontend('image/settings/favicon.' . $this->favicon)
            : asset('assets/img/default-favicon.ico');
    }

    // Accessor for hero_image_url
    public function getHeroImageUrlAttribute()
    {
        return $this->hero_image
            ? getFileUrlForFrontend('image/settings/hero.' . $this->hero_image)
            : asset('assets/img/default-hero.jpg');
    }
}
