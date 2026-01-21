@extends('layout')
@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('attendance.index') }}">Attendance</a></li>
                    <li class="breadcrumb-item active">{{ $course->name }}</li>
                </ol>
            </nav>

            <!-- Course Info Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-chart-bar mr-2"></i>Attendance Report: {{ $course->name }}</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="p-3 bg-light rounded">
                                <small class="text-muted d-block mb-1">Total Students</small>
                                <h4 class="mb-0 font-weight-bold">{{ $students->count() }}</h4>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="p-3 bg-light rounded">
                                <small class="text-muted d-block mb-1">Total Classes</small>
                                <h4 class="mb-0 font-weight-bold">{{ $attendances->count() }}</h4>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="p-3 bg-light rounded">
                                <small class="text-muted d-block mb-1">Average Attendance</small>
                                <h4 class="mb-0 font-weight-bold">
                                    {{ $students->count() > 0 ? round($students->avg('attendance_percentage'), 2) : 0 }}%
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Student-wise Attendance Statistics -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 font-weight-bold"><i class="fas fa-users mr-2 text-primary"></i>Student Attendance Summary</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Student Name</th>
                                    <th>Total Classes</th>
                                    <th>Present</th>
                                    <th>Absent</th>
                                    <th>Late</th>
                                    <th>Attendance %</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                    @php
                                        $absentCount = \App\Models\Attendance::where('course_id', $course->id)
                                            ->where('student_id', $student->id)
                                            ->where('status', 'absent')
                                            ->count();
                                        
                                        $lateCount = \App\Models\Attendance::where('course_id', $course->id)
                                            ->where('student_id', $student->id)
                                            ->where('status', 'late')
                                            ->count();
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><strong>{{ $student->name }}</strong></td>
                                        <td>{{ $student->total_classes }}</td>
                                        <td><span class="badge badge-success">{{ $student->present_classes }}</span></td>
                                        <td><span class="badge badge-danger">{{ $absentCount }}</span></td>
                                        <td><span class="badge badge-warning">{{ $lateCount }}</span></td>
                                        <td>
                                            <div class="progress" style="height: 25px;">
                                                <div class="progress-bar 
                                                    @if($student->attendance_percentage >= 75) bg-success
                                                    @elseif($student->attendance_percentage >= 60) bg-warning
                                                    @else bg-danger
                                                    @endif"
                                                    role="progressbar" 
                                                    style="width: {{ $student->attendance_percentage }}%">
                                                    {{ $student->attendance_percentage }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($student->attendance_percentage >= 75)
                                                <span class="badge badge-success">Good</span>
                                            @elseif($student->attendance_percentage >= 60)
                                                <span class="badge badge-warning">Average</span>
                                            @else
                                                <span class="badge badge-danger">Poor</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            No students enrolled in this course
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Attendance History -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 font-weight-bold"><i class="fas fa-history mr-2 text-primary"></i>Attendance History</h5>
                </div>
                <div class="card-body">
                    @forelse($attendances as $date => $records)
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="font-weight-bold mb-0">
                                    <i class="fas fa-calendar-day mr-2 text-primary"></i>
                                    {{ \Carbon\Carbon::parse($date)->format('l, F j, Y') }}
                                </h6>
                                <small class="text-muted">
                                    Marked by: {{ $records->first()->markedBy->name }}
                                </small>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="50">#</th>
                                            <th>Student</th>
                                            <th width="100">Status</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($records as $record)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $record->student->name }}</td>
                                                <td>
                                                    @if($record->status == 'present')
                                                        <span class="badge badge-success">Present</span>
                                                    @elseif($record->status == 'absent')
                                                        <span class="badge badge-danger">Absent</span>
                                                    @else
                                                        <span class="badge badge-warning">Late</span>
                                                    @endif
                                                </td>
                                                <td>{{ $record->remarks ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h5 class="font-weight-bold">No Attendance Records</h5>
                            <p class="text-muted">No attendance has been marked for this course yet.</p>
                            <a href="{{ route('attendance.index') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-plus mr-2"></i> Mark Attendance
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .breadcrumb-item a { color: var(--primary-color); text-decoration: none; }
    .progress { font-size: 12px; font-weight: bold; }
</style>

@endsection
