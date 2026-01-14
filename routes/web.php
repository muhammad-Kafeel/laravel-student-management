<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
// --- Your Original Controller Imports ---
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EnrollmentController;

// --- Model Imports ---
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Enrollment;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Welcome Page (Public)
Route::get('/', function () {
    return view('welcome');
});

// Dashboard Route (Protected - Requires Login)
Route::get('/dashboard', function () {
    // Fetch counts for the dashboard stats
    $studentCount = Student::count(); 
    $teacherCount = Teacher::count();
    $courseCount  = Course::count();
    $enrollmentCount = Enrollment::count();

    // Pass data to the dashboard view
    return view('dashboard', compact('studentCount', 'teacherCount', 'courseCount', 'enrollmentCount'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes (Protected - Requires Login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Your Original Resource Routes (Now Protected!)
    Route::resource('/students', StudentController::class);
    Route::resource('/teachers', TeacherController::class);
    Route::resource('/courses', CourseController::class);
    
    // Enrollment Routes
    Route::resource('/enrollments', EnrollmentController::class);
});

// Admin Only Routes (Protected - Requires Admin Role)
Route::middleware(['auth', 'admin'])->group(function () {
    // User Management Routes (Admin Panel)
    Route::resource('/users', UserController::class);
});

// Authentication Routes (Login, Register, etc.)
require __DIR__.'/auth.php';
