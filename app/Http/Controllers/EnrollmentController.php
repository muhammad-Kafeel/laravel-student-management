<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of all enrollments
     */
    public function index()
    {
        // Get all enrollments with student and course information
        $enrollments = Enrollment::with(['student', 'course'])->latest()->get();
        
        return view('enrollments.index', compact('enrollments'));
    }

    /**
     * Show the form for creating a new enrollment
     */
    public function create()
    {
        // Get all students and courses for the dropdown
        $students = Student::all();
        $courses = Course::all();
        
        return view('enrollments.create', compact('students', 'courses'));
    }

    /**
     * Store a newly created enrollment in storage
     */
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'enrollment_date' => 'required|date',
            'status' => 'required|in:active,completed,dropped'
        ]);

        // Check if student is already enrolled in this course
        $existingEnrollment = Enrollment::where('student_id', $request->student_id)
                                        ->where('course_id', $request->course_id)
                                        ->first();

        if ($existingEnrollment) {
            return redirect()->back()->with('error', 'Student is already enrolled in this course!');
        }

        // Create the enrollment
        Enrollment::create([
            'student_id' => $request->student_id,
            'course_id' => $request->course_id,
            'enrollment_date' => $request->enrollment_date,
            'status' => $request->status
        ]);

        return redirect()->route('enrollments.index')->with('success', 'Student enrolled successfully!');
    }

    /**
     * Display the specified enrollment
     */
    public function show(string $id)
    {
        $enrollment = Enrollment::with(['student', 'course'])->findOrFail($id);
        return view('enrollments.show', compact('enrollment'));
    }

    /**
     * Show the form for editing the specified enrollment
     */
    public function edit(string $id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $students = Student::all();
        $courses = Course::all();
        
        return view('enrollments.edit', compact('enrollment', 'students', 'courses'));
    }

    /**
     * Update the specified enrollment in storage
     */
    public function update(Request $request, string $id)
    {
        $enrollment = Enrollment::findOrFail($id);

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'enrollment_date' => 'required|date',
            'status' => 'required|in:active,completed,dropped'
        ]);

        $enrollment->update([
            'student_id' => $request->student_id,
            'course_id' => $request->course_id,
            'enrollment_date' => $request->enrollment_date,
            'status' => $request->status
        ]);

        return redirect()->route('enrollments.index')->with('success', 'Enrollment updated successfully!');
    }

    /**
     * Remove the specified enrollment from storage
     */
    public function destroy(string $id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->delete();

        return redirect()->route('enrollments.index')->with('success', 'Enrollment deleted successfully!');
    }
}
