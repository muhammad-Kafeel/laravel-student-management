<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            
            // Foreign Keys - Link to students, courses, and the user who marked attendance
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('marked_by')->constrained('users')->onDelete('cascade'); // Teacher/Admin who marked
            
            // Attendance Date
            $table->date('attendance_date');
            
            // Status: present, absent, late
            $table->enum('status', ['present', 'absent', 'late'])->default('present');
            
            // Optional: Remarks/Notes
            $table->text('remarks')->nullable();
            
            $table->timestamps();
            
            // Prevent duplicate attendance (same student, same course, same date)
            $table->unique(['student_id', 'course_id', 'attendance_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
