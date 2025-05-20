<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $fillable = [
        'fullname',
        'email',
        'password',
        'phone_number',
        'user_role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
