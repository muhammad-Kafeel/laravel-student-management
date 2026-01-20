@extends('layout')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-10">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/students') }}">Students</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Student Profile</li>
                </ol>
            </nav>
            <a href="{{ url('/students/' . $students->id . '/edit') }}" class="btn btn-primary btn-sm px-3 shadow-sm">
                <i class="fas fa-edit mr-1"></i> Edit Profile
            </a>
        </div>

        <div class="row">
            <!-- Student Info Card -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-primary py-5 text-center position-relative" style="border-radius: 12px 12px 0 0;">
                        <div class="position-absolute w-100" style="bottom: -40px; left: 0;">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($students->name) }}&background=f8fafc&color=2563eb&size=80" 
                                 class="rounded-circle border border-white shadow" 
                                 alt="Avatar"
                                 style="width: 80px; height: 80px; border-width: 4px !important;">
                        </div>
                    </div>

                    <div class="card-body pt-5 mt-3 px-4 pb-4">
                        <div class="text-center mb-4">
                            <h4 class="font-weight-bold mb-1">{{ $students->name }}</h4>
                            <p class="text-muted small"><i class="fas fa-id-badge mr-1"></i> Student ID: #{{ $students->id }}</p>
                        </div>

                        <div class="mb-3">
                            <div class="p-3 bg-light rounded shadow-sm">
                                <label class="text-muted small font-weight-bold text-uppercase mb-1 d-block">Contact Number</label>
                                <div class="font-weight-bold text-dark">
                                    <i class="fas fa-phone-alt text-primary mr-2"></i> {{ $students->mobile }}
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="p-3 bg-light rounded shadow-sm">
                                <label class="text-muted small font-weight-bold text-uppercase mb-1 d-block">Location</label>
                                <div class="font-weight-bold text-dark">
                                    <i class="fas fa-map-marker-alt text-primary mr-2"></i> {{ $students->address }}
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="p-3 bg-light rounded shadow-sm">
                                <label class="text-muted small font-weight-bold text-uppercase mb-1 d-block">Joined Date</label>
                                <div class="font-weight-bold text-dark">
                                    <i class="fas fa-calendar-alt text-primary mr-2"></i> {{ $students->created_at->format('M d, Y') }}
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="p-3 bg-light rounded shadow-sm">
                                <label class="text-muted small font-weight-bold text-uppercase mb-1 d-block">Status</label>
                                <span class="badge badge-success px-3 py-2">Active</span>
                            </div>
                        </div>

                        <a href="{{ url('/students') }}" class="btn btn-outline-secondary btn-block">
                            <i class="fas fa-arrow-left mr-2"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>

            <!-- Enrolled Courses Card -->
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0 font-weight-bold"><i class="fas fa-book mr-2 text-primary"></i>Enrolled Courses</h5>
                                <p class="text-muted small mb-0">Courses this student is currently enrolled in</p>
                            </div>
                            <span class="badge badge-primary badge-pill px-3 py-2">
                                {{ $students->courses->count() }} Course{{ $students->courses->count() != 1 ? 's' : '' }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body">
                        @if($students->courses->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($students->courses as $course)
                                    <div class="list-group-item border rounded mb-3 shadow-sm">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 class="font-weight-bold mb-2">{{ $course->name }}</h6>
                                                <p class="text-muted small mb-2">
                                                    <strong>Duration:</strong> {{ $course->duration }}
                                                </p>
                                                <p class="text-muted small mb-2">
                                                    <strong>Syllabus:</strong> {{ Str::limit($course->syllabus, 120) }}
                                                </p>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar-check mr-1"></i>
                                                        <strong>Enrolled:</strong> {{ \Carbon\Carbon::parse($course->pivot->enrollment_date)->format('M d, Y') }}
                                                    </small>
                                                    <small class="ml-3">
                                                        <strong>Status:</strong> 
                                                        @if($course->pivot->status == 'active')
                                                            <span class="badge badge-success">Active</span>
                                                        @elseif($course->pivot->status == 'completed')
                                                            <span class="badge badge-primary">Completed</span>
                                                        @else
                                                            <span class="badge badge-danger">Dropped</span>
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                                <h5 class="font-weight-bold">No Enrolled Courses</h5>
                                <p class="text-muted">This student is not enrolled in any courses yet.</p>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ url('/enrollments/create') }}" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus mr-2"></i> Enroll in Course
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
