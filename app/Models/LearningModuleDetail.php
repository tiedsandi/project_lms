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

    public function instructor()
    {
        return $this->belongsTo(Instructors::class);
    }

    public function details()
    {
        return $this->hasMany(LearningModuleDetail::class, 'learning_module_id');
    }
}
