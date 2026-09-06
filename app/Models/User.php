<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama_lengkap', 'email', 'password', 'role',
    ];

    protected $hidden = [
        'password',
    ];

    public const UPDATED_AT = null;
}