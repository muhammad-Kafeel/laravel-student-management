<?php

/*
|==========================================================================
| SECTION 1: IMPORTS (use statements)
|==========================================================================
| These lines "import" classes so we can use short names instead of full paths.
| Without these, we'd have to write the full path every time like:
|   App\Http\Controllers\CourseController::class
| With these imports, we just write:
|   CourseController::class
|
| REUSE IDEA: For a Hospital System, you'd import:
|   use App\Http\Controllers\DoctorController;
|   use App\Http\Controllers\PatientController;
|   use App\Http\Controllers\AppointmentController;
|
| For an E-Commerce System, you'd import:
|   use App\Http\Controllers\ProductController;
|   use App\Http\Controllers\OrderController;
|   use App\Http\Controllers\CategoryController;
*/

use App\Http\Controllers\ProfileController;     // Handles user profile (edit, update, delete)
use Illuminate\Support\Facades\Route;           // The Route class - required in every web.php
use App\Http\Controllers\CourseController;      // Handles Course CRUD operations
use App\Http\Controllers\TeacherController;     // Handles Teacher CRUD operations
use App\Http\Controllers\StudentController;     // Handles Student CRUD operations
use App\Http\Controllers\UserController;        // Handles User management (admin panel)
use App\Http\Controllers\EnrollmentController;  // Handles which students are in which courses
use App\Http\Controllers\AttendanceController;  // Handles marking and viewing attendance
use App\Http\Controllers\GlobalSearchController; // Handles searching across all records

// Model Imports - We use these directly in routes to query the database
// Models are the "bridge" between your PHP code and database tables
use App\Models\Course;      // Represents the 'courses' database table
use App\Models\Student;     // Represents the 'students' database table
use App\Models\Teacher;     // Represents the 'teachers' database table
use App\Models\Enrollment;  // Represents the 'enrollments' database table


/*
|==========================================================================
| SECTION 2: PUBLIC ROUTES (No Login Required)
|==========================================================================
| These routes are accessible by ANYONE - even without being logged in.
| Use these for: landing pages, about pages, contact forms, etc.
|
| Route::get( URL , WHAT TO DO )
|   - First parameter: the URL path (what user types in browser)
|   - Second parameter: a Controller method OR an anonymous function
*/

// The homepage - anyone can visit this
// URL: yoursite.com/
// Returns the 'resources/views/welcome.blade.php' file
// REUSE: Change 'welcome' to 'home', 'landing', 'index' for different sites
Route::get('/', function () {
    return view('welcome'); // 'welcome' = the view file name (welcome.blade.php)
});


/*
|==========================================================================
| SECTION 3: GLOBAL SEARCH ROUTE
|==========================================================================
| This is a single route but with extra features chained onto it.
| Chaining means we add extra behavior using -> (arrow/method chaining)
|
| REUSE: Same pattern for any search feature - just swap the controller:
|   Hospital:   [SearchController::class, 'search'] -- searches doctors, patients
|   E-Commerce: [SearchController::class, 'search'] -- searches products, orders
*/

Route::get('/search', [GlobalSearchController::class, 'search'])
    // [GlobalSearchController::class, 'search'] means:
    //   - Go to the GlobalSearchController file
    //   - Run the 'search' method/function inside it

    ->middleware(['auth'])
    // middleware(['auth']) = "Only allow this if the user is LOGGED IN"
    // If not logged in, Laravel automatically redirects to /login
    // This is Laravel's built-in 'auth' middleware

    ->name('search');
    // ->name('search') gives this route a nickname
    // Now in Blade templates you can write: route('search') instead of '/search'
    // This is useful because if you change the URL later,
    // you only change it in ONE place (here), not everywhere in your templates


/*
|==========================================================================
| SECTION 4: DASHBOARD ROUTE
|==========================================================================
| Protected route - requires both login AND email verification.
| Uses an anonymous function (inline logic) instead of a controller
| because the logic is simple (just counting records).
|
| REUSE: For any admin dashboard - just change what you count:
|   Hospital:   $doctorCount, $patientCount, $appointmentCount
|   E-Commerce: $productCount, $orderCount, $userCount, $revenue
|   Library:    $bookCount, $memberCount, $borrowingCount
*/

Route::get('/dashboard', function () {

    // ::count() is an Eloquent (Laravel ORM) method
    // It runs: SELECT COUNT(*) FROM students; on your database
    // No need to write raw SQL - Laravel handles it!
    $studentCount    = Student::count();
    $teacherCount    = Teacher::count();
    $courseCount     = Course::count();
    $enrollmentCount = Enrollment::count();

    // compact() is a PHP built-in function
    // compact('studentCount', 'teacherCount') is shorthand for:
    //   ['studentCount' => $studentCount, 'teacherCount' => $teacherCount]
    // It "packages" all these variables and sends them to the view
    // In your dashboard.blade.php, you can then use $studentCount directly
    return view('dashboard', compact('studentCount', 'teacherCount', 'courseCount', 'enrollmentCount'));

})
->middleware(['auth', 'verified'])
// TWO middlewares applied here:
//   'auth'     = must be logged in
//   'verified' = email must be verified (clicked the verification link)
// Both conditions must be TRUE to access this route

->name('dashboard');


/*
|==========================================================================
| SECTION 5: ROUTE GROUPS (Applying same middleware to multiple routes)
|==========================================================================
| Instead of writing ->middleware('auth') on every single route,
| we GROUP routes together and apply middleware ONCE to the whole group.
|
| Route::middleware('auth')->group(function() {
|     // All routes inside here automatically require login
| });
|
| REUSE: Same grouping pattern works for any role-based system:
|   ->middleware(['auth', 'verified'])   -- login + email verified
|   ->middleware(['auth', 'admin'])      -- login + admin role
|   ->middleware(['auth', 'premium'])    -- login + paid subscription
|   ->middleware(['auth', 'staff'])      -- login + staff role
*/

// Profile Routes - Only logged-in users can view/edit their own profile
Route::middleware('auth')->group(function () {

    // GET = Show the edit form (just loading the page)
    // URL: yoursite.com/profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    // PATCH = Submit the edit form (saving changes)
    // PATCH is used for PARTIAL updates (changing some fields, not all)
    // PUT would be used for COMPLETE replacement of all data
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // DELETE = Delete the user's account
    // Your HTML form uses method spoofing: @method('DELETE') in Blade
    // because HTML forms only support GET and POST natively
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|==========================================================================
| SECTION 6: ADMIN ONLY ROUTES (Full CRUD)
|==========================================================================
| CRUD = Create, Read, Update, Delete - the 4 basic database operations
|
| IMPORTANT: This block MUST come BEFORE the teacher routes below!
| Why? Because Laravel reads routes TOP TO BOTTOM.
| If teacher routes came first, '/teachers/create' might match
| '/teachers/{teacher}' with {teacher} = "create" - WRONG!
| Always put more SPECIFIC routes before more GENERAL ones.
|
| The 'admin' middleware is a CUSTOM middleware you created.
| It's in: app/Http/Middleware/... and checks if user role = 'admin'
|
| REUSE: Replace 'admin' with your role name:
|   Hospital:   ->middleware(['auth', 'doctor_admin'])
|   E-Commerce: ->middleware(['auth', 'shop_owner'])
|   Library:    ->middleware(['auth', 'librarian'])
*/

Route::middleware(['auth', 'admin'])->group(function () {

    // -----------------------------------------------------------------------
    // TEACHERS - Full CRUD (Admin Only)
    // -----------------------------------------------------------------------
    // Notice the PATTERN: every resource follows the same URL structure
    //
    //  GET  /teachers           → index()   = list all teachers
    //  GET  /teachers/create    → create()  = show the "add new" form
    //  POST /teachers           → store()   = save new teacher to DB
    //  GET  /teachers/{id}      → show()    = view ONE teacher's profile
    //  GET  /teachers/{id}/edit → edit()    = show the edit form
    //  PATCH/PUT /teachers/{id} → update()  = save edits to DB
    //  DELETE /teachers/{id}    → destroy() = delete from DB
    //
    // This is the standard Laravel RESTful convention

    Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
    // URL: /teachers/create  →  shows a blank form to add a new teacher
    // The 'create' method in TeacherController just returns a view with a form

    Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store');
    // URL: /teachers (POST)  →  receives form data and saves to database
    // This is where validation happens and the record gets created

    Route::get('/teachers', [TeacherController::class, 'index']);
    // URL: /teachers  →  lists all teachers (admin can see this too)
    // Note: No ->name() here because the teacher route group below
    // defines the named version 'teachers.index'

    Route::get('/teachers/{teacher}', [TeacherController::class, 'show']);
    // URL: /teachers/5  →  shows teacher with ID 5
    // {teacher} is a ROUTE PARAMETER - it captures the value from the URL
    // Laravel's Route Model Binding automatically fetches the Teacher
    // model from DB where id = 5. You don't need to write:
    //   $teacher = Teacher::find($id);
    // Laravel does it automatically if your method signature is:
    //   public function show(Teacher $teacher)

    Route::get('/teachers/{teacher}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
    // URL: /teachers/5/edit  →  shows pre-filled edit form for teacher ID 5

    Route::patch('/teachers/{teacher}', [TeacherController::class, 'update'])->name('teachers.update');
    // Receives the edited form data and updates the database record

    Route::put('/teachers/{teacher}', [TeacherController::class, 'update']);
    // Same as PATCH but PUT = complete replacement
    // Both are defined to support different form submission methods
    // Some browsers/forms send PUT, some send PATCH

    Route::delete('/teachers/{teacher}', [TeacherController::class, 'destroy'])->name('teachers.destroy');
    // Deletes the teacher record from database
    // In your Blade form: <form method="POST"> + @method('DELETE')


    // -----------------------------------------------------------------------
    // STUDENTS - Full CRUD (Admin Only)
    // -----------------------------------------------------------------------
    // Exact same pattern as Teachers above - just different controller
    // REUSE: Copy this pattern for ANY new resource (Patient, Product, Book, etc.)

    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::patch('/students/{student}', [StudentController::class, 'update'])->name('students.update');
    Route::put('/students/{student}', [StudentController::class, 'update']);   // Extra method for compatibility
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');


    // -----------------------------------------------------------------------
    // COURSES - Full CRUD (Admin Only)
    // -----------------------------------------------------------------------
    // Again, same pattern. Notice how consistent Laravel CRUD routes are.
    // Once you learn this pattern, you apply it to ANY resource.

    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    Route::patch('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
    Route::put('/courses/{course}', [CourseController::class, 'update']);
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');


    // -----------------------------------------------------------------------
    // RESOURCE SHORTCUT - Route::resource()
    // -----------------------------------------------------------------------
    // Instead of writing all 7 routes manually (like above),
    // Route::resource() creates ALL 7 routes automatically in ONE line!
    //
    // Route::resource('/users', UserController::class) creates:
    //   GET    /users            → index()
    //   GET    /users/create     → create()
    //   POST   /users            → store()
    //   GET    /users/{user}     → show()
    //   GET    /users/{user}/edit → edit()
    //   PATCH  /users/{user}     → update()
    //   DELETE /users/{user}     → destroy()
    //
    // REUSE: Use Route::resource() whenever you need full CRUD for a resource
    //   Hospital:   Route::resource('/doctors', DoctorController::class);
    //   E-Commerce: Route::resource('/products', ProductController::class);
    //   Library:    Route::resource('/books', BookController::class);

    Route::resource('/users', UserController::class);
    // Full user management panel for admin

    Route::resource('/enrollments', EnrollmentController::class);
    // Full enrollment management - which student is in which course


    // -----------------------------------------------------------------------
    // ATTENDANCE - Custom Routes (Not using resource shortcut)
    // -----------------------------------------------------------------------
    // Attendance doesn't follow standard CRUD exactly, so routes are defined manually
    // Notice there's no edit/update/delete for attendance - by design

    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    // URL: /attendance  →  lists all attendance records

    Route::get('/attendance/mark', [AttendanceController::class, 'create'])->name('attendance.create');
    // URL: /attendance/mark  →  shows the form to mark attendance
    // NOTE: This uses 'create' method but URL is 'mark' - that's fine!
    // The URL can be different from the method name

    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    // Receives the attendance form and saves records to DB

    Route::get('/attendance/{course}', [AttendanceController::class, 'show'])->name('attendance.show');
    // URL: /attendance/5  →  shows attendance for course ID 5
    // {course} uses Route Model Binding to auto-fetch the Course model
});


/*
|==========================================================================
| SECTION 7: TEACHER & ADMIN VIEW-ONLY ROUTES
|==========================================================================
| The 'teacher' middleware (custom) allows BOTH teachers AND admins to view.
| This works because your admin middleware probably also passes the teacher check,
| OR your teacher middleware checks: role == 'teacher' OR role == 'admin'
|
| VIEW-ONLY means: only GET routes (no create, edit, delete)
|
| ROUTE ORDER MATTERS HERE TOO:
| Admin routes (above) must come FIRST because:
| - Admin block defines /teachers (no name) and /teachers/{teacher} (no name)
| - Teacher block defines them WITH names (teachers.index, teachers.show)
| - Laravel matches the FIRST route it finds
| - So admin uses the unnamed versions, teacher routes define the named versions
|
| REUSE: Use this pattern for any "viewer" role:
|   Hospital: ->middleware(['auth', 'nurse']) -- can view but not modify
|   E-Commerce: ->middleware(['auth', 'staff']) -- can view orders but not delete
*/

Route::middleware(['auth', 'teacher'])->group(function () {

    // Students - teachers can see the list but can't add/edit/delete
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');

    // Teachers - teachers can see the list and each other's profiles
    Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
    Route::get('/teachers/{teacher}', [TeacherController::class, 'show'])->name('teachers.show');

    // Courses - teachers can browse all courses
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
});

// This is separated into its own group but uses the same 'teacher' middleware
// Could have been included in the group above - same result either way
// Separated possibly to keep "student show" logic clearly distinct
Route::middleware(['auth', 'teacher'])->group(function () {

    // Teachers can view individual student profiles
    Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
    // URL: /students/10  →  shows student with ID 10
    // {student} = route parameter captured from URL
    // Laravel auto-fetches: Student::find(10) for you
});


/*
|==========================================================================
| SECTION 8: AUTH ROUTES (Login, Register, Forgot Password, etc.)
|==========================================================================
| This line INCLUDES another routes file: routes/auth.php
| That file is auto-generated by Laravel Breeze/Jetstream and contains:
|   GET  /login           → show login form
|   POST /login           → process login
|   POST /logout          → logout user
|   GET  /register        → show registration form
|   POST /register        → process registration
|   GET  /forgot-password → show forgot password form
|   ... etc
|
| REUSE: Always keep this line - it's needed for any authenticated app
| You can customize auth.php for: social login, 2FA, magic links, etc.
*/
require __DIR__.'/auth.php';


/*
|==========================================================================
| QUICK REFERENCE: How This Pattern Adapts to Other Systems
|==========================================================================
|
| YOUR STUDENT SYSTEM          HOSPITAL SYSTEM             E-COMMERCE SYSTEM
| ─────────────────────────────────────────────────────────────────────────
| Student    →                 Patient     →               Customer
| Teacher    →                 Doctor      →               Staff/Admin
| Course     →                 Department  →               Category
| Enrollment →                 Appointment →               Order
| Attendance →                 Treatment   →               Shipment
|
| MIDDLEWARE ROLES:
| 'admin'   →                  'hospital_admin' →          'shop_owner'
| 'teacher' →                  'nurse'          →          'warehouse_staff'
|
| The ROUTING LOGIC stays IDENTICAL - only the:
|   - Controller names change
|   - Model names change
|   - Middleware role names change
|   - URL paths change (/students → /patients → /customers)
|
| The PATTERNS (groups, middleware, resource routes, named routes)
| are UNIVERSAL in Laravel and work for ANY type of application.
|==========================================================================
*/