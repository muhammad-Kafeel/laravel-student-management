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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            
            // Foreign Keys - Link to students and courses tables
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            
            // Enrollment Date
            $table->date('enrollment_date');
            
            // Status: active, completed, dropped
            $table->enum('status', ['active', 'completed', 'dropped'])->default('active');
            
            $table->timestamps();
            
            // Prevent duplicate enrollments (same student can't enroll in same course twice)
            $table->unique(['student_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
