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
}
