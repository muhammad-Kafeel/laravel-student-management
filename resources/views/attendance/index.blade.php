@extends('layout')
@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="font-weight-bold">Attendance Management</h3>
                    <p class="text-muted">Mark and view attendance for courses</p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            @endif

            <!-- Mark Attendance Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-check-circle mr-2"></i>Mark Attendance</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('attendance.create') }}" method="GET">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-600">Select Course *</label>
                                <select name="course_id" class="form-control" required>
                                    <option value="">-- Choose Course --</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-600">Select Date *</label>
                                <input type="date" name="attendance_date" class="form-control" 
                                       value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-arrow-right mr-2"></i> Continue to Mark Attendance
                        </button>
                    </form>
                </div>
            </div>

            <!-- View Reports Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-chart-bar mr-2"></i>View Attendance Reports</h5>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-3">Select a course to view detailed attendance reports and statistics</p>
                    
                    <div class="list-group">
                        @forelse($courses as $course)
                            <a href="{{ route('attendance.show', $course->id) }}" 
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 font-weight-bold">{{ $course->name }}</h6>
                                    <small class="text-muted">{{ $course->students->count() }} Students Enrolled</small>
                                </div>
                                <i class="fas fa-chevron-right text-muted"></i>
                            </a>
                        @empty
                            <div class="text-center py-4 text-muted">
                                No courses available
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .font-weight-600 { font-weight: 600; color: #334155; margin-bottom: 8px; display: inline-block; }
    .list-group-item:hover { background-color: #f8f9fa; }
</style>

@endsection
