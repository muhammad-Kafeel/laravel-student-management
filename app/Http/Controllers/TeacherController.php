<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;             // For methods that return a blade file
use Illuminate\Http\RedirectResponse; // For methods that redirect after an action
use App\Models\Teacher;               // Links this controller to the Teacher model

class TeacherController extends Controller
{
    /**
     * INDEX: Display a list of all teachers.
     * Accessible at: your-site.com/teachers
     */
    public function index(): View
    {
        // 1. Ask the Model to fetch all records from the 'teachers' table
        $teachers = Teacher::all();

        // 2. Open 'resources/views/teachers/index.blade.php' and pass the data
        return view('teachers.index')->with('teachers', $teachers);
    }

    /**
     * CREATE: Show the form to add a new teacher.
     */
    public function create(): View
    {
        // Simply displays the 'create.blade.php' view file
        return view('teachers.create');
    }

    /**
     * STORE: Save the new teacher data from the form to the database.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. $request->all() grabs everything from the form (name, address, mobile)
        $input = $request->all();

        // 2. Insert the new row into the database using the Model
        Teacher::create($input);

        // 3. Go back to the index page with a success 'flash' notification
        return redirect('teachers')->with('flash_message', 'Teacher Added!');
    }

    /**
     * SHOW: Display details of a specific teacher.
     */
    public function show(string $id): View
    {
        // 1. Find the teacher or fail with 404 if not found
        $teacher = Teacher::findOrFail($id);

        // 2. Load the show view and pass the teacher data
        return view('teachers.show')->with('teacher', $teacher);
    }

    /**
     * EDIT: Find a specific teacher and show their details in an editable form.
     */
    public function edit(string $id): View
    {
        // 1. Search for the teacher using the unique ID from the URL
        $teacher = Teacher::find($id);

        // 2. Send that specific teacher's info to the 'edit.blade.php' file
        return view('teachers.edit')->with('teacher', $teacher);
    }

    /**
     * UPDATE: Apply the changes made in the Edit form to the database.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        // 1. Locate the existing record in the database
        $teacher = Teacher::find($id);

        // 2. Capture the new data submitted by the user
        $input = $request->all();

        // 3. Update the record with the new information
        $teacher->update($input);

        // 4. Send the user back to the list with an update message
        return redirect('teachers')->with('flash_message', 'Teacher Updated!');
    }

    /**
     * DESTROY: Permanently delete a teacher record.
     */
    public function destroy(string $id): RedirectResponse
    {
        // Teacher::destroy is a shortcut that finds AND deletes in one line
        Teacher::destroy($id);

        // Redirect to the list to show the updated table without the deleted record
        return redirect('teachers')->with('flash_message', 'Teacher Deleted!');
    }
}
