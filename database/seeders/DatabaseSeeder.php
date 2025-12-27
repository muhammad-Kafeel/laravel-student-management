<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // This tells Laravel: "Use the Student model/factory to create 20 records"
    \App\Models\Student::factory(20)->create();
    
    \App\Models\Teacher::factory(10)->create();
    $this->call([
        CourseSeeder::class, // Register your seeder here
    ]);
    }
}
