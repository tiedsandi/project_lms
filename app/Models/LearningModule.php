<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningModule extends Model
{
    protected $fillable = [
        'name',
        'description',
        'instructor_id',
        'is_active',
    ];
}
