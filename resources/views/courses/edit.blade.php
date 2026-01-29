{{-- 1. Extend the main layout --}}
@extends('layout')
@section('content')
 
<div class="card">
  <div class="card-header">Edit Course</div>
  <div class="card-body">
      
      {{-- 2. Action points to the update method with the specific ID --}}
      <form action="{{ url('courses/' .$course->id) }}" method="post">
        {!! csrf_field() !!}

        {{-- 3. Professional Laravel Requirement: Spoofing the PATCH method --}}
        @method("PATCH")

        {{-- 4. Hidden ID field (Professional practice for tracking) --}}
        <input type="hidden" name="id" id="id" value="{{$course->id}}" />

        {{-- 5. Name input with existing data loaded --}}
        <label>Name</label><br>
        <input type="text" name="name" id="name" value="{{$course->name}}" class="form-control"><br>
        
        {{-- 6. Syllabus textarea with existing data loaded --}}
        <label>Syllabus</label><br>
        <textarea name="syllabus" id="syllabus" class="form-control" rows="5">{{$course->syllabus}}</textarea><br>
        
        {{-- 7. Duration input with existing data loaded --}}
        <label>Duration</label><br>
        <input type="text" name="duration" id="duration" value="{{$course->duration}}" class="form-control"><br>
        
        {{-- 8. Teacher Selection Dropdown --}}
        <label>Assign Teacher</label><br>
        <select name="teacher_id" class="form-control">
            <option value="">-- Select a Teacher --</option>
            @foreach($teachers as $teacher)
                <option value="{{ $teacher->id }}" {{ $course->teacher_id == $teacher->id ? 'selected' : '' }}>
                    {{ $teacher->name }}
                </option>
            @endforeach
        </select><br>
        
        {{-- 9. Update button --}}
        <input type="submit" value="Update" class="btn btn-success"><br>
    </form>
   
  </div>
</div>
 
@stop