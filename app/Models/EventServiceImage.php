<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventServiceImage extends Model
{
    use HasFactory;

    protected $table = 'event_service_images';

    protected $fillable = [
        'event_service_id',
        'image',
    ];

    // Relation: image belongs to one service
    public function service()
    {
        return $this->belongsTo(EventService::class, 'event_service_id');
    }
}
