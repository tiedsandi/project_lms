<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    protected $fillable = [
        'major_id',
        'user_id',
        'gender',
        'date_of_birth',
        'palace_of_birth',
        'phone',
        'photo',
        'is_active',
    ];

    public function major()
    {
        return $this->belongsTo(Majors::class, 'major_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
