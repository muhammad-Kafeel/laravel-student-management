{{-- 1. Inherit the main layout structure (header, sidebar, and CSS) --}}
@extends('layout')

{{-- 2. Define the 'content' section to be injected into the layout's @yield('content') --}}
@section('content')

<div class="card">
    {{-- 3. Visual header for the form card --}}
    <div class="card-header">Add New Course</div>
    
    <div class="card-body">

        {{-- 4. Check if the $errors MessageBag contains any validation failures --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    {{-- 5. Loop through every error message and display it as a list item --}}
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- 6. Form submission: POSTs data to the '/courses' URL mapped in web.php --}}
        <form action="{{ url('courses') }}" method="post">
            
            {{-- 7. CSRF Security: Generates a hidden token to protect against cross-site attacks --}}
            {!! csrf_field() !!}

            {{-- 8. Course Name Input Field --}}
            <label>Course Name</label><br>
            {{-- 
                old('name'): Keeps the typed value if validation fails
                @error('name'): Adds the 'is-invalid' class to turn the border red if this field has a mistake 
            --}}
            <input type="text" name="name" value="{{ old('name') }}" 
                   class="form-control @error('name') is-invalid @enderror"><br>
            
            {{-- 9. Syllabus Multi-line Input --}}
            <label>Syllabus</label><br>
            {{-- Textareas place the old() value inside the opening and closing tags --}}
            <textarea name="syllabus" class="form-control @error('syllabus') is-invalid @enderror" 
                      rows="5">{{ old('syllabus') }}</textarea><br>
            
            {{-- 10. Course Duration Input --}}
            <label>Duration</label><br>
            <input type="text" name="duration" value="{{ old('duration') }}" 
                   class="form-control @error('duration') is-invalid @enderror"><br>
            
            {{-- 11. Submission button triggers the CourseController@store method --}}
            <input type="submit" value="Save Course" class="btn btn-success">
        </form>

    </div>
</div>

{{-- 12. Close the content section --}}
@stop