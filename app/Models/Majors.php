<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Majors extends Model
{
    protected $fillable = [
        'name',
        'is_active',
    ];

    public function MajorDetail()
    {
        return $this->belongsTo(MajorDetail::class);
    }
}
