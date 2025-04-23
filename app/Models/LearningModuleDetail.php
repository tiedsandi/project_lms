<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningModuleDetail extends Model
{
    protected $fillable = [
        'learning_module_id',
        'file_name',
        'file',
        'reference_link',
    ];
}
