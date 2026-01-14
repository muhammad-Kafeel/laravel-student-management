<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'enrollment_date',
        'status'
    ];

    protected $casts = [
        'enrollment_date' => 'date',
    ];

    /**
     * Relationship: Enrollment belongs to a Student
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Relationship: Enrollment belongs to a Course
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
