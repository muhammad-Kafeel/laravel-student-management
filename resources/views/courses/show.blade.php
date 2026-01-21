@extends('layout')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-10">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/courses') }}">Courses</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Course Details</li>
                </ol>
            </nav>
            @if(Auth::user()->isAdmin())
                <a href="{{ url('/courses/' . $course->id . '/edit') }}" class="btn btn-primary btn-sm px-3 shadow-sm">
                    <i class="fas fa-edit mr-1"></i> Edit Course
                </a>
            @endif
        </div>

        <div class="row">
            <!-- Course Info Card -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-primary py-5 text-center position-relative" style="border-radius: 12px 12px 0 0;">
                        <div class="position-absolute w-100" style="bottom: -40px; left: 0;">
                            <div class="bg-white rounded-circle border border-white shadow d-inline-flex align-items-center justify-content-center" 
                                 style="width: 80px; height: 80px; border-width: 4px !important;">
                                <i class="fas fa-book fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>

                    <div class="card-body pt-5 mt-3 px-4 pb-4">
                        <div class="text-center mb-4">
                            <h4 class="font-weight-bold mb-1">{{ $course->name }}</h4>
                            <p class="text-muted small"><i class="fas fa-hashtag mr-1"></i> Course ID: #{{ $course->id }}</p>
                        </div>

                        <div class="mb-3">
                            <div class="p-3 bg-light rounded shadow-sm">
                                <label class="text-muted small font-weight-bold text-uppercase mb-1 d-block">Duration</label>
                                <div class="font-weight-bold text-dark">
                                    <i class="fas fa-clock text-primary mr-2"></i> {{ $course->duration }}
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="p-3 bg-light rounded shadow-sm">
                                <label class="text-muted small font-weight-bold text-uppercase mb-1 d-block">Syllabus</label>
                                <div class="text-dark" style="font-size: 14px;">
                                    {{ $course->syllabus }}
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="p-3 bg-light rounded shadow-sm">
                                <label class="text-muted small font-weight-bold text-uppercase mb-1 d-block">Total Students</label>
                                <div class="font-weight-bold text-dark">
                                    <i class="fas fa-users text-primary mr-2"></i> {{ $course->students->count() }} Student{{ $course->students->count() != 1 ? 's' : '' }}
                                </div>
                            </div>
                        </div>

                        <a href="{{ url('/courses') }}" class="btn btn-outline-secondary btn-block">
                            <i class="fas fa-arrow-left mr-2"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>

            <!-- Enrolled Students Card -->
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0 font-weight-bold"><i class="fas fa-user-graduate mr-2 text-primary"></i>Enrolled Students</h5>
                                <p class="text-muted small mb-0">Students currently enrolled in this course</p>
                            </div>
                            <span class="badge badge-primary badge-pill px-3 py-2">
                                {{ $course->students->count() }} Student{{ $course->students->count() != 1 ? 's' : '' }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body">
                        @if($course->students->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($course->students as $student)
                                    <div class="list-group-item border rounded mb-3 shadow-sm">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="d-flex align-items-center flex-grow-1">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=3b82f6&color=fff&size=50" 
                                                     class="rounded-circle mr-3" 
                                                     alt="Avatar"
                                                     style="width: 50px; height: 50px;">
                                                <div>
                                                    <h6 class="font-weight-bold mb-1">{{ $student->name }}</h6>
                                                    <p class="text-muted small mb-2">
                                                        <i class="fas fa-phone-alt mr-1"></i> {{ $student->mobile }}
                                                    </p>
                                                    <p class="text-muted small mb-2">
                                                        <i class="fas fa-map-marker-alt mr-1"></i> {{ Str::limit($student->address, 50) }}
                                                    </p>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        <small class="text-muted">
                                                            <i class="fas fa-calendar-check mr-1"></i>
                                                            <strong>Enrolled:</strong> {{ \Carbon\Carbon::parse($student->pivot->enrollment_date)->format('M d, Y') }}
                                                        </small>
                                                        <small class="ml-3">
                                                            <strong>Status:</strong> 
                                                            @if($student->pivot->status == 'active')
                                                                <span class="badge badge-success">Active</span>
                                                            @elseif($student->pivot->status == 'completed')
                                                                <span class="badge badge-primary">Completed</span>
                                                            @else
                                                                <span class="badge badge-danger">Dropped</span>
                                                            @endif
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <a href="{{ url('/students/' . $student->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-user-graduate fa-3x text-muted mb-3"></i>
                                <h5 class="font-weight-bold">No Enrolled Students</h5>
                                <p class="text-muted">No students are enrolled in this course yet.</p>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ url('/enrollments/create') }}" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus mr-2"></i> Enroll Students
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .breadcrumb-item a { color: var(--primary-color); text-decoration: none; font-weight: 500; }
    .breadcrumb-item.active { color: #64748b; font-weight: 500; }
    .bg-light { background-color: #f1f5f9 !important; }
</style>

@endsection
