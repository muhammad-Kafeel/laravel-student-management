@extends('layout')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-3">
                <li class="breadcrumb-item"><a href="{{ url('/teachers') }}">Teachers</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Teacher</li>
            </ol>
        </nav>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 font-weight-bold">
                    <i class="fas fa-user-plus mr-2 text-success"></i>Register New Teacher
                </h5>
                <p class="text-muted small mb-0">Enter the details to add a new teacher to the system.</p>
            </div>

            <div class="card-body p-4">
                <form action="{{ url('teachers') }}" method="post">
                    @csrf
                    <div class="form-group mb-4">
                        <label class="font-weight-600">Teacher Name</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light border-right-0"><i class="far fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control border-left-0 pl-0" name='name' placeholder="e.g. Professor John Doe" required>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-600">Address</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light border-right-0"><i class="fas fa-map-marker-alt"></i></span>
                            </div>
                            <input type="text" class="form-control border-left-0 pl-0" name='address' placeholder="City, Country" required>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-600">Mobile Number</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light border-right-0"><i class="fas fa-phone-alt"></i></span>
                            </div>
                            <input type="text" class="form-control border-left-0 pl-0" name='mobile' placeholder="+123456789" required>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ url('/teachers') }}" class="btn btn-light border px-4">Cancel</a>
                        <button type="submit" class="btn btn-success px-5 shadow-sm font-weight-bold">
                            Save Teacher <i class="fas fa-check ml-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .font-weight-600 { font-weight: 600; color: #334155; margin-bottom: 8px; display: inline-block; }
    .form-control:focus {
        border-color: #10b981; /* Success Green color for teachers */
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
</style>

@endsection