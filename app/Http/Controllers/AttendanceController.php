<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display attendance page - Select course and date
     */
    public function index()
    {
        $courses = Course::all();
        return view('attendance.index', compact('courses'));
    }

    /**
     * Show the form to mark attendance for a specific course and date
     */
    public function create(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'attendance_date' => 'required|date'
        ]);

        $course = Course::with('students')->findOrFail($request->course_id);
        $attendanceDate = Carbon::parse($request->attendance_date);

        // Get existing attendance for this course and date
        $existingAttendance = Attendance::where('course_id', $request->course_id)
            ->where('attendance_date', $attendanceDate)
            ->get()
            ->keyBy('student_id');

        return view('attendance.create', compact('course', 'attendanceDate', 'existingAttendance'));
    }

    /**
     * Store attendance records
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'attendance_date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*.student_id' => 'required|exists:students,id',
            'attendance.*.status' => 'required|in:present,absent,late',
        ]);

        $saved = 0;
        $updated = 0;

        foreach ($request->attendance as $record) {
            $attendance = Attendance::updateOrCreate(
                [
                    'student_id' => $record['student_id'],
                    'course_id' => $request->course_id,
                    'attendance_date' => $request->attendance_date,
                ],
                [
                    'status' => $record['status'],
                    'remarks' => $record['remarks'] ?? null,
                    'marked_by' => Auth::id(),
                ]
            );

            if ($attendance->wasRecentlyCreated) {
                $saved++;
            } else {
                $updated++;
            }
        }

        $message = "Attendance saved successfully! ($saved new, $updated updated)";
        return redirect()->route('attendance.index')->with('success', $message);
    }

    /**
     * Display attendance report for a specific course
     */
    public function show(string $id)
    {
        $course = Course::with(['students', 'enrollments'])->findOrFail($id);
        
        // Get all attendance records for this course
        $attendances = Attendance::where('course_id', $id)
            ->with(['student', 'markedBy'])
            ->orderBy('attendance_date', 'desc')
            ->get()
            ->groupBy('attendance_date');

        // Calculate attendance statistics for each student
        $students = $course->students->map(function ($student) use ($id) {
            $totalClasses = Attendance::where('course_id', $id)
                ->where('student_id', $student->id)
                ->count();

            $presentClasses = Attendance::where('course_id', $id)
                ->where('student_id', $student->id)
                ->where('status', 'present')
                ->count();

            $percentage = $totalClasses > 0 ? round(($presentClasses / $totalClasses) * 100, 2) : 0;

            $student->total_classes = $totalClasses;
            $student->present_classes = $presentClasses;
            $student->attendance_percentage = $percentage;

            return $student;
        });

        return view('attendance.show', compact('course', 'attendances', 'students'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
