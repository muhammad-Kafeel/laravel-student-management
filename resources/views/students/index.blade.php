@extends('layout')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="font-weight-bold">Students</h3>
        <p class="text-muted">Manage and view all registered students in the system.</p>
    </div>
    <a href="{{ url('/students/create') }}" class="btn btn-primary shadow-sm">
        <i class="fas fa-plus mr-2"></i> Add New Student
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0 px-4">#</th>
                        <th class="border-0">Full Name</th>
                        <th class="border-0">Address</th>
                        <th class="border-0">Mobile Number</th>
                        <th class="border-0 text-right px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $item)
                    <tr>
                        <td class="px-4 text-muted">{{ $loop->iteration }}</td>
                        <td>
                            <div class="font-weight-bold text-dark">{{ $item->name }}</div>
                        </td>
                        <td class="text-muted">{{ $item->address }}</td>
                        <td><span class="badge badge-soft-info">{{ $item->mobile }}</span></td>
                        <td class="text-right px-4">
                            <a href="{{ url('/students/' . $item->id) }}" class="btn btn-sm btn-light border text-info mr-1" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ url('/students/' . $item->id . '/edit') }}" class="btn btn-sm btn-light border text-primary mr-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ url('/students/' . $item->id) }}" style="display:inline">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-sm btn-light border text-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this record?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
