<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users'; // Ensure it points to the correct table

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
