<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EventService extends Model
{
    use HasFactory;

    protected $table = 'event_services';

    protected $fillable = [
        'title',
        'thumbnail',
        'description',
    ];

    // Relation: one service has many images
    public function images()
    {
        return $this->hasMany(EventServiceImage::class, 'event_service_id');
    }
}
