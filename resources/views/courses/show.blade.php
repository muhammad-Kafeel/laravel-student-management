{{-- 1. Extend the main layout to keep the sidebar and header consistent --}}
@extends('layout')

{{-- 2. Define the content section --}}
@section('content')

<div class="card">
  {{-- 3. Header showing which course we are viewing --}}
  <div class="card-header">Course Details</div>
  
  <div class="card-body">
  
    {{-- 4. Course Information Area --}}
    <div class="card-body">
        {{-- Displaying the Course Name --}}
        <h5 class="card-title"><strong>Name: </strong> {{ $course->name }}</h5>
        
        {{-- Displaying the Full Syllabus (not limited like in the index table) --}}
        <p class="card-text"><strong>Syllabus: </strong> {{ $course->syllabus }}</p>
        
        {{-- Displaying the Course Duration --}}
        <p class="card-text"><strong>Duration: </strong> {{ $course->duration }}</p>
    </div>
    
    <hr>
    
    {{-- 5. Navigation button to go back to the list --}}
    <a href="{{ url('/courses') }}" class="btn btn-primary btn-sm">
        <i class="fa fa-arrow-left"></i> Back to Courses
    </a>

  </div>
</div>

@endsection