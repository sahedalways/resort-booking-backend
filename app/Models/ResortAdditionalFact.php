<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResortAdditionalFact extends Model
{
    protected $fillable = ['resort_id', 'name'];

    public function resort()
    {
        return $this->belongsTo(Resort::class);
    }
}
