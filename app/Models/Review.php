<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'resort_id',
        'user_id',
        'comment',
        'star',
    ];

    // Relations
    public function resort()
    {
        return $this->belongsTo(Resort::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
