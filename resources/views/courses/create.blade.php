{{-- 1. Inherit the main layout structure (header, sidebar, and CSS) --}}
@extends('layout')

{{-- 2. Define the 'content' section to be injected into the layout's @yield('content') --}}
@section('content')

<div class="card">
    {{-- 3. Visual header for the form card --}}
    <div class="card-header">Add New Course</div>

    {{-- Simply add this where you want the message to appear --}}
    <x-alert />

    <div class="card-body">

        {{-- 4. Check if the $errors MessageBag contains any validation failures --}}
        <!-- @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    {{-- 5. Loop through every error message and display it as a list item --}}
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif -->

        {{-- 6. Form submission: POSTs data to the '/courses' URL mapped in web.php --}}
        <!-- <form action="{{ url('courses') }}" method="post">
    {!! csrf_field() !!}

    {{-- Course Name Field --}}
    <div class="mb-3">
        <label class="form-label">Course Name</label>
        {{-- 
            1. @error('name') is-invalid @enderror: 
               This adds the Bootstrap 'is-invalid' class only if the 'name' validation fails. 
               This turns the border of the input box RED.
        --}}
        <input type="text" name="name" value="{{ old('name') }}" 
               class="form-control @error('name') is-invalid @enderror">
        
        {{-- 
            2. @error('name')...@enderror:
               This block only renders if there is an error for 'name'.
               The $message variable is automatically created by Laravel.
        --}}
        @error('name')
            <div class="text-danger mt-1" style="font-size: 0.9rem;">
                <i class="fa fa-info-circle"></i> {{ $message }}
            </div>
        @enderror
    </div>

    {{-- Syllabus Field --}}
    <div class="mb-3">
        <label class="form-label">Syllabus</label>
        <textarea name="syllabus" rows="4" 
                  class="form-control @error('syllabus') is-invalid @enderror">{{ old('syllabus') }}</textarea>
        @error('syllabus')
            <div class="text-danger mt-1" style="font-size: 0.9rem;">
                <i class="fa fa-info-circle"></i> {{ $message }}
            </div>
        @enderror
    </div>

    {{-- Duration Field --}}
    <div class="mb-3">
        <label class="form-label">Duration</label>
        <input type="text" name="duration" value="{{ old('duration') }}" 
               class="form-control @error('duration') is-invalid @enderror">
        @error('duration')
            <div class="text-danger mt-1" style="font-size: 0.9rem;">
                <i class="fa fa-info-circle"></i> {{ $message }}
            </div>
        @enderror
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-success">Save Course</button>
    </div>
</form> -->
        <form action="{{ url('courses') }}" method="post">

            {{-- 7. CSRF Security: Generates a hidden token to protect against cross-site attacks --}}
            {!! csrf_field() !!}

            <x-form-input name="name" label="Course Name" />

            {{-- Syllabus Field --}}
            <div class="mb-3">
                <label class="form-label">Syllabus</label>
                <textarea name="syllabus" rows="4"
                    class="form-control @error('syllabus') is-invalid @enderror">{{ old('syllabus') }}</textarea>
                @error('syllabus')
                    <div class="text-danger mt-1" style="font-size: 0.9rem;">
                        <i class="fa fa-info-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>
            <x-form-input name="duration" label="Course Duration" />

            <button type="submit" class="btn btn-success">Save</button>
        </form>

    </div>
</div>

{{-- 12. Close the content section --}}
@stop