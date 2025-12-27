<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses'; // Optional, but good practice
    protected $primaryKey = 'id';
    
    // Whitelist the fields so Laravel allows them to be saved
    protected $fillable = ['name', 'syllabus', 'duration'];
}
