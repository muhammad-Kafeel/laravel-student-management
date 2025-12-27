<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course; // Don't forget to import your Model

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // Add a few professional sample courses
        Course::create([
            'name' => 'Laravel Web Development',
            'syllabus' => 'Introduction to MVC, Routing, Controllers, and Eloquent ORM.',
            'duration' => '3 Months'
        ]);

        Course::create([
            'name' => 'Advanced PHP Programming',
            'syllabus' => 'Deep dive into OOP, Namespaces, and Design Patterns.',
            'duration' => '2 Months'
        ]);

        Course::create([
            'name' => 'Frontend Mastery',
            'syllabus' => 'Mastering HTML5, CSS3, Bootstrap 5, and JavaScript Basics.',
            'duration' => '4 Months'
        ]);
    }
}