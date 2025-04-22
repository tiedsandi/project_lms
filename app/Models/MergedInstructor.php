<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MergedInstructor extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'major',
        'phone',
        'photo',
        'status',
        'source',
        'created_at'
    ];
}
