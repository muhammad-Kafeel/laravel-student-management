@extends('layout')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-3">
                <li class="breadcrumb-item"><a href="{{ route('enrollments.index') }}">Enrollments</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Enrollment</li>
            </ol>
        </nav>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 font-weight-bold">
                    <i class="fas fa-edit mr-2 text-warning"></i>Update Enrollment
                </h5>
                <p class="text-muted small mb-0">Modify enrollment details</p>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('enrollments.update', $enrollment->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <!-- Student Selection -->
                    <div class="form-group mb-4">
                        <label class="font-weight-600">Select Student *</label>
                        <select name="student_id" class="form-control" required>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" 
                                    {{ $enrollment->student_id == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Course Selection -->
                    <div class="form-group mb-4">
                        <label class="font-weight-600">Select Course *</label>
                        <select name="course_id" class="form-control" required>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" 
                                    {{ $enrollment->course_id == $course->id ? 'selected' : '' }}>
                                    {{ $course->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('course_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Enrollment Date -->
                    <div class="form-group mb-4">
                        <label class="font-weight-600">Enrollment Date *</label>
                        <input type="date" name="enrollment_date" class="form-control" 
                               value="{{ \Carbon\Carbon::parse($enrollment->enrollment_date)->format('Y-m-d') }}" required>
                        @error('enrollment_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="form-group mb-4">
                        <label class="font-weight-600">Status *</label>
                        <select name="status" class="form-control" required>
                            <option value="active" {{ $enrollment->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="completed" {{ $enrollment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="dropped" {{ $enrollment->status == 'dropped' ? 'selected' : '' }}>Dropped</option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('enrollments.index') }}" class="btn btn-light border px-4">Cancel</a>
                        <button type="submit" class="btn btn-warning text-white px-5 shadow-sm font-weight-bold">
                            Update Enrollment <i class="fas fa-sync-alt ml-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .font-weight-600 { font-weight: 600; color: #334155; margin-bottom: 8px; display: inline-block; }
    .breadcrumb-item a { color: var(--primary-color); text-decoration: none; }
    .breadcrumb-item.active { color: #64748b; }
</style>

@endsection
