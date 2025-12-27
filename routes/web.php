<?php

use Illuminate\Support\Facades\Route;
// --- Controller Imports ---
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController; // Removed the leading backslash

// --- Model Imports ---
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;

/*
|--------------------------------------------------------------------------
| Dashboard Route
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    // 1. Fetch counts for the dashboard stats
    $studentCount = Student::count(); 
    $teacherCount = Teacher::count();
    $courseCount  = Course::count(); // Renamed for consistency

    // 2. Pass data to the dashboard view
    return view('dashboard', compact('studentCount', 'teacherCount', 'courseCount'));
});

/*
|--------------------------------------------------------------------------
| Resource Routes (CRUD)
|--------------------------------------------------------------------------
| These single lines automatically create index, create, store, show, edit, update, 
| and destroy routes for each module.
*/
Route::resource('/students', StudentController::class);
Route::resource('/teachers', TeacherController::class);
Route::resource('/courses', CourseController::class);