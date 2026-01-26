<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
// --- Your Original Controller Imports ---
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\AttendanceController;

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
Route::get('search',[App\Http\Controllers\UserController::class,'search']);

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
});

// Teacher & Admin Routes (View Only - Teachers and Admins can VIEW)
Route::middleware(['auth', 'teacher'])->group(function () {

    // Students - View Only (index) - Teachers and Admins can VIEW
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');

    // Teachers - View Only (index and show) - Teachers can VIEW
    Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
    Route::get('/teachers/{teacher}', [TeacherController::class, 'show'])->name('teachers.show');
    
    // Courses - View Only (index and show) - Teachers and Admins can VIEW
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
});

// Admin Only Routes (Full CRUD Access) - ONLY ADMINS can CREATE/EDIT/DELETE
Route::middleware(['auth', 'admin'])->group(function () {

    // ✅ ALLOW ADMIN TO VIEW TEACHERS LIST & PROFILE
    Route::get('/teachers', [TeacherController::class, 'index']);
    Route::get('/teachers/{teacher}', [TeacherController::class, 'show']);

    // Students - Create, Edit, Delete (Admin Only)
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::patch('/students/{student}', [StudentController::class, 'update'])->name('students.update');
    Route::put('/students/{student}', [StudentController::class, 'update']);
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
    
    // Teachers - Create, Edit, Delete (Admin Only)
    Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
    Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store');
    Route::get('/teachers/{teacher}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
    Route::patch('/teachers/{teacher}', [TeacherController::class, 'update'])->name('teachers.update');
    Route::put('/teachers/{teacher}', [TeacherController::class, 'update']);
    Route::delete('/teachers/{teacher}', [TeacherController::class, 'destroy'])->name('teachers.destroy');
    
    // Courses - Create, Edit, Delete (Admin Only)
    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    Route::patch('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
    Route::put('/courses/{course}', [CourseController::class, 'update']);
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
    
    // User Management Routes (Admin Panel)
    Route::resource('/users', UserController::class);
    
    // Enrollment Management (Admin Only)
    Route::resource('/enrollments', EnrollmentController::class);
    
    // Attendance Management (Admin Only)
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/mark', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance/{course}', [AttendanceController::class, 'show'])->name('attendance.show');
});

// Teacher & Admin Routes (View Only - Students SHOW)
Route::middleware(['auth', 'teacher'])->group(function () {

    // Students - View Only (show) - Teachers and Admins can VIEW
    Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');

});

// Authentication Routes (Login, Register, etc.)
require __DIR__.'/auth.php';
