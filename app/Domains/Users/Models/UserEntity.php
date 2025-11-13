<?php

namespace App\Domains\Users\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserEntity extends Authenticatable
{
    use HasRoles;
    protected $table = 'admins';
    protected $guard_name = 'admin';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}