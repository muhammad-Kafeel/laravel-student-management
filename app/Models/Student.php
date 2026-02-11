<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'students';
    protected $primaryKey = 'id';
    protected $fillable = ['name','address','mobile','user_id'];
    
    /**
     * Relationship: Student belongs to a User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Relationship: Student has many Enrollments
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Relationship: Student belongs to many Courses (through enrollments)
     * This is theMany-to-Many relationship!
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments')
                    ->withPivot('enrollment_date', 'status')
                    ->withTimestamps();
    }
}
