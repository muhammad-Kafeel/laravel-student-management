@extends('layout')

@section('content')
<div class="container-fluid">
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h3 class="font-weight-bold mb-1">Welcome, {{ Auth::user()->name }}!</h3>
                    <p class="text-muted mb-0">You're logged in successfully.</p>
                </div>
                <div>
                    @if(Auth::user()->isAdmin())
                        <span class="badge badge-pill badge-success px-3 py-2">Admin</span>
                    @elseif(Auth::user()->isTeacher())
                        <span class="badge badge-pill badge-primary px-3 py-2">Teacher</span>
                    @else
                        <span class="badge badge-pill badge-secondary px-3 py-2">Student</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-light text-primary p-3 mr-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user-graduate fa-2x"></i>
                        </div>
                        <div>
                            <p class="text-muted small font-weight-bold text-uppercase mb-0">Total Students</p>
                            <h2 class="font-weight-bold mb-0">{{ $studentCount }}</h2>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <a href="{{ url('/students') }}" class="text-primary font-weight-bold small text-decoration-none">
                            View all students <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-light text-success p-3 mr-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-chalkboard-teacher fa-2x"></i>
                        </div>
                        <div>
                            <p class="text-muted small font-weight-bold text-uppercase mb-0">Total Teachers</p>
                            <h2 class="font-weight-bold mb-0">{{ $teacherCount }}</h2>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <a href="{{ url('/teachers') }}" class="text-success font-weight-bold small text-decoration-none">
                            View all teachers <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-light text-purple p-3 mr-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; color: #6f42c1;">
                            <i class="fas fa-book fa-2x"></i>
                        </div>
                        <div>
                            <p class="text-muted small font-weight-bold text-uppercase mb-0">Total Courses</p>
                            <h2 class="font-weight-bold mb-0">{{ $courseCount }}</h2>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <a href="{{ url('/courses') }}" class="font-weight-bold small text-decoration-none" style="color: #6f42c1;">
                            View all courses <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-light text-warning p-3 mr-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-clipboard-list fa-2x"></i>
                        </div>
                        <div>
                            <p class="text-muted small font-weight-bold text-uppercase mb-0">Enrollments</p>
                            <h2 class="font-weight-bold mb-0">{{ $enrollmentCount }}</h2>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <a href="{{ url('/enrollments') }}" class="text-warning font-weight-bold small text-decoration-none">
                            View enrollments <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection