@extends('layout')
@section('content')

<div class="row">
    <div class="col-12 mb-4">
        <h2 class="font-weight-bold">System Overview</h2>
        <p class="text-muted">Welcome back! Here is a summary of your school management data.</p>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm" style="border-left: 5px solid #2563eb !important;">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-light p-3 mr-3">
                        <i class="fas fa-user-graduate text-primary fa-lg"></i>
                    </div>
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Total Students</div>
                        <h3 class="mb-0 font-weight-bold">{{ $studentCount ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm" style="border-left: 5px solid #10b981 !important;">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-light p-3 mr-3">
                        <i class="fas fa-chalkboard-teacher text-success fa-lg"></i>
                    </div>
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Active Teachers</div>
                        <h3 class="mb-0 font-weight-bold">{{$teacherCount ?? 0}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm" style="border-left: 5px solid #f59e0b !important;">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-light p-3 mr-3">
                        <i class="fas fa-book text-warning fa-lg"></i>
                    </div>
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Total Courses</div>
                        <h3 class="mb-0 font-weight-bold">{{ $courseCount ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white font-weight-bold border-0 pt-4 px-4">
                <i class="fas fa-rocket mr-2 text-primary"></i> Getting Started
            </div>
            <div class="card-body px-4">
                <p>Welcome to your new Student Management System. To get started, you can perform the following actions:</p>
                <div class="list-group list-group-flush">
                    <a href="{{ url('/students/create') }}" class="list-group-item list-group-item-action border-0 px-0">
                        <i class="fas fa-plus-circle mr-2 text-primary"></i> Register a new student in the database
                    </a>
                    <a href="{{ url('/students') }}" class="list-group-item list-group-item-action border-0 px-0">
                        <i class="fas fa-list mr-2 text-primary"></i> View and manage existing student records
                    </a>
                    <a href="{{ url('/teachers/create') }}" class="list-group-item list-group-item-action border-0 px-0">
                        <i class="fas fa-plus-circle mr-2 text-primary"></i> Register a new teacher in the database
                    </a>
                    <a href="{{ url('/teachers') }}" class="list-group-item list-group-item-action border-0 px-0">
                        <i class="fas fa-list mr-2 text-primary"></i> View and manage existing Teachers records
                    </a>
                    <a href="{{ url('/courses/create') }}" class="list-group-item list-group-item-action border-0 px-0">
                        <i class="fas fa-plus-circle mr-2 text-primary"></i> Register a new Course in the database
                    </a>
                    <a href="{{ url('/courses') }}" class="list-group-item list-group-item-action border-0 px-0">
                        <i class="fas fa-list mr-2 text-primary"></i> View and manage existing Course records
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm bg-dark text-white h-100">
            <div class="card-body d-flex flex-column justify-content-center text-center p-4">
                <i class="fas fa-shield-alt fa-3x mb-3 text-primary"></i>
                <h5 class="font-weight-bold">System Secure</h5>
                <p class="small opacity-75">All data is backed up daily and secured with Laravel's built-in encryption.</p>
            </div>
        </div>
    </div>
</div>

@endsection