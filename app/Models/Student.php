<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $primaryKey = 'student_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'student_id',
        'full_name',
        'date_of_birth',
        'gender',
        '_section',
        'phone_number',
        'email',
        'picture',
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id', 'student_id');
    }

    public function user()
    {
        return $this->hasOne(\App\Models\User::class, 'student_id', 'student_id');
    }
}
