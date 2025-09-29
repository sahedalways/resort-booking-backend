<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResortImage extends Model
{
    protected $fillable = ['resort_id', 'image'];

    public function resort()
    {
        return $this->belongsTo(Resort::class);
    }
}
