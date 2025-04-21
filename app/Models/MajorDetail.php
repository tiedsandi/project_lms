<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MajorDetail extends Model
{
    protected $fillable = [
        'user_id',
        'major_id',
    ];
}
