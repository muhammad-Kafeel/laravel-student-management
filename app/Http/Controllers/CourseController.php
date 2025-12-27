<?php

namespace App\Http\Controllers;

// --- Imports: Bringing in the necessary tools ---
use App\Models\Course;             // Connects to the 'courses' table in your database
use Illuminate\Http\RedirectResponse; // Tool used to send users to a different page after an action
use Illuminate\Http\Request;          // Tool that captures data sent from forms
use Illuminate\View\View;             // Tool used to render and display HTML pages

class CourseController extends Controller
{
    /**
     * Display a listing of all courses.
     * Accessible via: GET /courses
     */
    public function index(): View
    {
        // 1. Eloquent command to fetch every row from the courses table
        $courses = Course::all();

        // 2. Locate 'resources/views/courses/index.blade.php' and send the data to it
        return view('courses.index')->with('courses', $courses);
    }

    /**
     * Show the empty form to add a new course.
     * Accessible via: GET /courses/create
     */
    public function create(): View
    {
        // Simply displays the 'create.blade.php' form file
        return view('courses.create');
    }

    /**
     * Save the newly created course into the database.
     * Accessible via: POST /courses
     */
  public function store(Request $request): RedirectResponse
{
    // 1. Define the rules and custom error messages
    $request->validate([
        // name: Only letters and spaces. No random symbols or numbers allowed.
        'name'     => 'required|regex:/^[a-zA-Z\s\-]+$/|max:255',
        
        // syllabus: Must be text, at least 20 chars, and cannot be ONLY numbers.
        'syllabus' => 'required|string|min:20|not_regex:/^[0-9\s]+$/',
        
        // duration: Allows letters and numbers like "6 Months" or "1 Year".
        'duration' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
    ], [
        // 2. Custom Messages: This makes your app feel professional to the admin
        'name.regex'         => 'The course name should only contain letters and spaces.',
        'syllabus.min'       => 'Please provide a more detailed syllabus (at least 20 characters).',
        'syllabus.not_regex' => 'The syllabus cannot consist of only numbers.',
        'duration.regex'     => 'Duration should be like "6 Months" or "12 Weeks".',
    ]);

    // 3. Save to database if validation passes
    $input = $request->all();
    Course::create($input);

    return redirect('courses')->with('flash_message', 'Course Added Successfully!');
}

    /**
     * Display the full details of a single specific course.
     * Accessible via: GET /courses/{id}
     */
    public function show(string $id): View
    {
        // 1. Search the database for the course matching this specific ID
        $course = Course::find($id);

        // 2. Return the 'show.blade.php' view with that one course's data
        return view('courses.show')->with('courses', $course);
    }

    /**
     * Show the form for editing an existing course.
     * Accessible via: GET /courses/{id}/edit
     */
    public function edit(string $id): View
    {
        // 1. Retrieve the existing data so the form can be pre-filled
        $course = Course::find($id);

        // 2. Send that data to 'edit.blade.php'
        return view('courses.edit')->with('courses', $course);
    }

    /**
     * Update the database with new information from the edit form.
     * Accessible via: PUT/PATCH /courses/{id}
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        // 1. Find the existing record that needs updating
        $course = Course::find($id);

        // 2. Capture the updated information from the form
        $input = $request->all();

        // 3. Overwrite the old data with the new data in the database
        $course->update($input);

        // 4. Send the user back to the list with an update confirmation
        return redirect('courses')->with('flash_message', 'Course Updated!');
    }

    /**
     * Delete a specific course permanently.
     * Accessible via: DELETE /courses/{id}
     */
    public function destroy(string $id): RedirectResponse
    {
        // 1. Find the course by ID (findOrFail crashes safely if ID doesn't exist)
        $course = Course::findOrFail($id);

        // 2. Remove the record from the database table
        $course->delete();

        // 3. Send the user back to the list so the table refreshes
        return redirect('courses')->with('flash_message', 'Course deleted successfully!');
    }
}