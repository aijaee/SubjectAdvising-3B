<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';
    protected $primaryKey = 'course_id';

    protected $fillable = [
        'course_id',
        'course_name',
        'description',
        'duration',
        'instructor',
        'year_level',
        'course_fee',
    ];

    public function enrollments()
    {
        return $this->hasMany(\App\Models\Enrollment::class, 'course_id', 'course_id');
    }
}
