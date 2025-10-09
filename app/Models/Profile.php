<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'avatar',
        'gender',
        'present_address',
        'permanent_address',
        'marital_status',
        'date_of_birth',
        'national_id',
        'nationality',
        'religion',
    ];

    // Relation: Profile belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
