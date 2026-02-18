<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;

class GlobalSearchController extends Controller
{
    /**
     * GLOBAL SEARCH: Search across Students, Teachers, and Courses at once.
     * Route: GET /search?query=...
     */
    public function search(Request $request)
    {
        // 1. Get the search term from the URL (e.g. /search?query=ali)
        $query = $request->get('query');

        // 2. If nothing was typed, go back to where the user came from
        if (!$query) {
            return redirect()->back();
        }

        // 3. Search Students table (name, address, mobile)
        $students = Student::where('name',    'LIKE', "%{$query}%")
                           ->orWhere('address', 'LIKE', "%{$query}%")
                           ->orWhere('mobile',  'LIKE', "%{$query}%")
                           ->get();

        // 4. Search Teachers table (name, address, mobile)
        $teachers = Teacher::where('name',    'LIKE', "%{$query}%")
                           ->orWhere('address', 'LIKE', "%{$query}%")
                           ->orWhere('mobile',  'LIKE', "%{$query}%")
                           ->get();

        // 5. Search Courses table (name, syllabus)
        $courses = Course::where('name',     'LIKE', "%{$query}%")
                         ->orWhere('syllabus', 'LIKE', "%{$query}%")
                         ->get();

        // 6. Count total results found across all three tables
        $totalResults = $students->count() + $teachers->count() + $courses->count();

        // 7. Pass everything to the search results view
        return view('search.results', compact('students', 'teachers', 'courses', 'query', 'totalResults'));
    }
}
