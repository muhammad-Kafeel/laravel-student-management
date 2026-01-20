@extends('layout')
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-3">
                    <li class="breadcrumb-item"><a href="{{ url('/students') }}">Students</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add New Student</li>
                </ol>
            </nav>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 font-weight-bold"><i class="fas fa-user-plus mr-2 text-primary"></i>Register New Student
                    </h5>
                    <p class="text-muted small mb-0">Fill in the details below to add a student to the system.</p>
                </div>

                <div class="card-body p-4">
                    <form action="{{ url('students') }}" method="post">
                        {!! csrf_field() !!}

                        {{-- Full Name --}}
                        <div class="form-group mb-4">
                            <label class="font-weight-600">Full Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light"><i class="far fa-user"></i></span>
                                </div>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" placeholder="e.g. John Doe" required>
                            </div>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Address --}}
                        <div class="form-group mb-4">
                            <label class="font-weight-600">Residential Address</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light"><i class="fas fa-map-marker-alt"></i></span>
                                </div>
                                <input type="text" name="address" id="address" value="{{ old('address') }}" class="form-control" placeholder="e.g. 123 Street, City" required>
                            </div>
                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Mobile --}}
                        <div class="form-group mb-4">
                            <label class="font-weight-600">Mobile Number</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light"><i class="fas fa-phone-alt"></i></span>
                                </div>
                                <input type="text" name="mobile" id="mobile" value="{{ old('mobile') }}" class="form-control" placeholder="e.g. +92 300 1234567" required>
                            </div>
                            @error('mobile')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ url('/students') }}" class="btn btn-light border px-4">
                                <i class="fas fa-arrow-left mr-2"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                Save Student <i class="fas fa-check-circle ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-4">
                <p class="text-muted small"><i class="fas fa-lock mr-1"></i> Data is encrypted and stored securely.</p>
            </div>
        </div>
    </div>

    <style>
        .font-weight-600 {
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
            display: inline-block;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .input-group-text {
            color: #94a3b8;
            border-color: #ced4da;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: #64748b;
        }
    </style>

@endsection
