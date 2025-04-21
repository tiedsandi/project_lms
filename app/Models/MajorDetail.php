<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MajorDetail extends Model
{
    protected $fillable = [
        'user_id',
        'major_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function majors()
    {
        return $this->belongsTo(Majors::class, 'major_id');
    }
}
