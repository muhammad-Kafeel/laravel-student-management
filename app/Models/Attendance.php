<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'marked_by',
        'attendance_date',
        'status',
        'remarks'
    ];

    protected $casts = [
        'attendance_date' => 'date',
    ];

    /**
     * Relationship: Attendance belongs to a Student
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Relationship: Attendance belongs to a Course
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Relationship: Attendance was marked by a User (Teacher/Admin)
     */
    public function markedBy()
    {
        return $this->belongsTo(User::class, 'marked_by');
    }
}
