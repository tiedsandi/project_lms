<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Majors extends Model
{
    protected $fillable = [
        'name',
        'is_active',
    ];

    public function majorDetail()
    {
        return $this->hasOne(MajorDetail::class, 'major_id');
    }

    public function pic()
    {
        return $this->hasOneThrough(
            User::class,    // Target: User
            MajorDetail::class, // Melalui: MajorDetail
            'major_id',     // Foreign key di MajorDetail
            'id',           // Foreign key di User (default 'id')
            'id',           // Local key di Major
            'user_id'       // Local key di MajorDetail
        );
    }
}
