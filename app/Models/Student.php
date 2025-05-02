<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function courses() {
        return $this->belongsToMany(Course::class, 'enrollments');
    }

    protected $fillable = ['firstname', 'lastname', 'email', 'phone', 'address', 'course_of_study', 'profile_picture'];
    use HasFactory;
}
