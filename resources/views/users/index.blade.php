@extends('layout')
@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="font-weight-bold">User Management</h3>
            <p class="text-muted">Manage user accounts and roles</p>
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

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-4">#</th>
                            <th class="border-0">Name</th>
                            <th class="border-0">Email</th>
                            <th class="border-0">Current Role</th>
                            <th class="border-0">Change Role</th>
                            <th class="border-0">Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="px-4 text-muted">{{ $user->id }}</td>
                                <td>
                                    <div class="font-weight-bold text-dark">{{ $user->name }}</div>
                                </td>
                                <td class="text-muted">{{ $user->email }}</td>
                                <td>
                                    @if($user->role == 'admin')
                                        <span class="badge badge-success">Admin</span>
                                    @elseif($user->role == 'teacher')
                                        <span class="badge badge-primary">Teacher</span>
                                    @else
                                        <span class="badge badge-secondary">Student</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('users.update', $user->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('PATCH')
                                        
                                        <select name="role" class="form-control form-control-sm d-inline-block" style="width: auto;" onchange="this.form.submit()">
                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="teacher" {{ $user->role == 'teacher' ? 'selected' : '' }}>Teacher</option>
                                            <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Student</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="text-muted">{{ $user->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
