<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Course;
use App\Models\Enrollment;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // Get all available courses for selection during registration
        $courses = Course::all();
        return view('auth.register', compact('courses'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'address' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:20'],
            'courses' => ['nullable', 'array'],
            'courses.*' => ['exists:courses,id'],
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student', // Set default role as student
        ]);

        // Create student profile linked to the user
        $student = Student::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'address' => $request->address,
            'mobile' => $request->mobile,
        ]);

        // Enroll student in selected courses
        if ($request->has('courses') && !empty($request->courses)) {
            foreach ($request->courses as $courseId) {
                Enrollment::create([
                    'student_id' => $student->id,
                    'course_id' => $courseId,
                    'enrollment_date' => now(),
                    'status' => 'active',
                ]);
            }
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
