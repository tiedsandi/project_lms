<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    protected $fillable = [
        'user_id',
        'role_id'
    ];

    public function role()
    {
        return $this->belongsTo(Roles::class);
    }
}
