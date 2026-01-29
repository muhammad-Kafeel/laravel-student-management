<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    // 1. Table Name (Tell Laravel which table this model uses)
    protected $table = 'teachers';

    // 2. Primary Key (Tell Laravel which column is the ID)
    protected $primaryKey = 'id';

    // 3. Fillable (The most important part for security!)
    protected $fillable = ['name', 'address', 'mobile'];

    /**
     * Define relationship: A teacher has many courses
     * This allows you to get all courses for a teacher using: $teacher->courses
     */
    public function courses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }
}
