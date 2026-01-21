@extends('layout')
@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('attendance.index') }}">Attendance</a></li>
                    <li class="breadcrumb-item active">Mark Attendance</li>
                </ol>
            </nav>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1"><i class="fas fa-clipboard-check mr-2"></i>{{ $course->name }}</h5>
                            <small>{{ $attendanceDate->format('l, F j, Y') }}</small>
                        </div>
                        <span class="badge badge-light px-3 py-2">
                            {{ $course->students->count() }} Students
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('attendance.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <input type="hidden" name="attendance_date" value="{{ $attendanceDate->format('Y-m-d') }}">

                        @if($course->students->isEmpty())
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                No students are enrolled in this course yet.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="50">#</th>
                                            <th>Student Name</th>
                                            <th>Mobile</th>
                                            <th width="250">Status</th>
                                            <th>Remarks (Optional)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($course->students as $student)
                                            @php
                                                $existing = $existingAttendance->get($student->id);
                                                $currentStatus = $existing ? $existing->status : 'present';
                                                $currentRemarks = $existing ? $existing->remarks : '';
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <strong>{{ $student->name }}</strong>
                                                    <input type="hidden" name="attendance[{{ $loop->index }}][student_id]" value="{{ $student->id }}">
                                                </td>
                                                <td>{{ $student->mobile }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                        <label class="btn btn-outline-success btn-sm {{ $currentStatus == 'present' ? 'active' : '' }}">
                                                            <input type="radio" name="attendance[{{ $loop->index }}][status]" value="present" 
                                                                   {{ $currentStatus == 'present' ? 'checked' : '' }}> Present
                                                        </label>
                                                        <label class="btn btn-outline-danger btn-sm {{ $currentStatus == 'absent' ? 'active' : '' }}">
                                                            <input type="radio" name="attendance[{{ $loop->index }}][status]" value="absent"
                                                                   {{ $currentStatus == 'absent' ? 'checked' : '' }}> Absent
                                                        </label>
                                                        <label class="btn btn-outline-warning btn-sm {{ $currentStatus == 'late' ? 'active' : '' }}">
                                                            <input type="radio" name="attendance[{{ $loop->index }}][status]" value="late"
                                                                   {{ $currentStatus == 'late' ? 'checked' : '' }}> Late
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="attendance[{{ $loop->index }}][remarks]" 
                                                           class="form-control form-control-sm" 
                                                           placeholder="e.g., Sick, Excused"
                                                           value="{{ $currentRemarks }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('attendance.index') }}" class="btn btn-light border px-4">
                                    <i class="fas fa-arrow-left mr-2"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary px-5">
                                    <i class="fas fa-save mr-2"></i> Save Attendance
                                </button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .breadcrumb-item a { color: var(--primary-color); text-decoration: none; }
    .btn-group-toggle .btn { border-radius: 4px; margin: 0 2px; }
</style>

@endsection
