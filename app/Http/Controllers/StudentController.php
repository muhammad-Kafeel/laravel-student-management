<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Http\RedirectResponse; // Tool to redirect the user after an action
use App\Models\Student;               // The Model that connects to the 'students' database table
use Illuminate\View\View;              // Tool to render the HTML Blade files

class StudentController extends Controller
{
    /**
     * 1. INDEX: Display a list of all students with search functionality.
     * Route: GET /students
     */
    public function index(Request $request): View
    {
        // Get search query from request
        $search = $request->get('search');
        
        // If search query exists, filter students
        if ($search) {
            $std = Student::where('name', 'LIKE', "%{$search}%")
                         ->orWhere('address', 'LIKE', "%{$search}%")
                         ->orWhere('mobile', 'LIKE', "%{$search}%")
                         ->get();
        } else {
            // Fetch all students if no search query
            $std = Student::all();
        }
        
        // Pass the student data to the 'students.index' view
        return view('students.index')->with('students', $std);
    }

    /**
     * 2. CREATE: Show the form to add a new student.
     * Route: GET /students/create
     */
    public function create(): View
    {
        // Load the empty form view for the user to fill out
        return view('students.create');
    }

    /**
     * 3. STORE: Save the new student data to the database.
     * Route: POST /students
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => 'required|regex:/^[a-zA-Z\s\-]+$/|max:255',
            'address' => 'required|string|min:20|not_regex:/^[0-9\s]+$/',
            'mobile' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
        ], [
            'name.regex'         => 'The course name should only contain letters and spaces.',
            'syllabus.min'       => 'Please provide a more detailed syllabus (at least 20 characters).',
            'syllabus.not_regex' => 'The syllabus cannot consist of only numbers.',
            'duration.regex'     => 'Duration should be like "6 Months" or "12 Weeks".',
        ]);
        // Get all data sent from the form (Name, Address, Mobile, etc.)
        $input = $request->all();
        
        // Use the Student model to insert a new row in the table
        Student::create($input);
        
        // Send the user back to the list with a success notification
        return redirect('students')->with('flash_message', 'student Added!');
    }

    /**
     * 4. SHOW: View details of one specific student.
     * Route: GET /students/{id}
     */
    public function show(string $id): View
    {
        // findOrFail is safer: it shows a 404 page if the ID doesn't exist
        $students = Student::findOrFail($id);
        
        // Pass the single student's data to the show view
        return view('students.show')->with('students', $students);
    }

    /**
     * 5. EDIT: Show the form to edit an existing student.
     * Route: GET /students/{id}/edit
     */
    public function edit(string $id): View
    {
        // Find the specific student record to pre-fill the form
        $student = Student::find($id);

        // Return the edit view with the existing student data
        return view('students.edit')->with('students', $student);
    }

    /**
     * 6. UPDATE: Save changes to an existing student.
     * Route: PUT/PATCH /students/{id}
     */
    public function update(Request $request, string $id)
    {
        // 1. Locate the existing student in the database
        $student = Student::find($id);

        // 2. Capture the updated data from the request
        $input = $request->all();

        // 3. Apply the changes to the database record
        $student->update($input);

        // 4. Redirect the user back to the main list with a success message
        return redirect('students')->with('flash_message', 'Student Updated Successfully!');
    }

    /**
     * 7. DESTROY: Delete a student record.
     * Route: DELETE /students/{id}
     */
    public function destroy(string $id)
    {
        // 1. Find the specific student record to be removed
        // Note: You can change the comment below to "Find student" for accuracy!
        $students = Student::find($id);
        
        // 2. Remove the record from the database
        $students->delete();
        
        // 3. Redirect to the list so the UI refreshes and shows the item is gone
        return redirect('students')->with('flash_message', 'students deleted successfully!');
    }
}