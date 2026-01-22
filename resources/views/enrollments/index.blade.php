@extends('layout')
@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="font-weight-bold">Enrollments</h3>
            <p class="text-muted">Manage student course enrollments</p>
        </div>
        <a href="{{ route('enrollments.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus mr-2"></i> Enroll Student
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-4">#</th>
                            <th class="border-0">Student</th>
                            <th class="border-0">Course</th>
                            <th class="border-0">Enrollment Date</th>
                            <th class="border-0">Status</th>
                            <th class="border-0 text-right px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($enrollments as $enrollment)
                            <tr>
                                <td class="px-4 text-muted">{{ $enrollment->id }}</td>
                                <td>
                                    <div class="font-weight-bold text-dark">{{ $enrollment->student->name }}</div>
                                </td>
                                <td class="text-muted">{{ $enrollment->course->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($enrollment->enrollment_date)->format('M d, Y') }}</td>
                                <td>
                                    @if($enrollment->status == 'active')
                                        <span class="badge badge-success">Active</span>
                                    @elseif($enrollment->status == 'completed')
                                        <span class="badge badge-primary">Completed</span>
                                    @else
                                        <span class="badge badge-danger">Dropped</span>
                                    @endif
                                </td>
                                <td class="text-right px-4">
                                    <a href="{{ route('enrollments.edit', $enrollment->id) }}" class="btn btn-sm btn-light border text-primary mr-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('enrollments.destroy', $enrollment->id) }}" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this enrollment?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light border text-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No enrollments found. <a href="{{ route('enrollments.create') }}" class="text-primary">Enroll a student</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
