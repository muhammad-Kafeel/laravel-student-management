@extends('layout')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-3">
                <li class="breadcrumb-item"><a href="{{ url('/students') }}">Students</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Student</li>
            </ol>
        </nav>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 font-weight-bold">
                    <i class="fas fa-user-edit mr-2 text-warning"></i>Update Student Details
                </h5>
                <p class="text-muted small mb-0">Modify the information for <strong>{{ $students->name }}</strong>.</p>
            </div>

            <div class="card-body p-4">
                <form action="{{ url('students/' .$students->id) }}" method="post">
                    {!! csrf_field() !!}
                    @method("PATCH")

                    <input type="hidden" name="id" id="id" value="{{$students->id}}" />

                    <div class="form-group mb-4">
                        <label class="font-weight-600">Full Name</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light border-right-0"><i class="far fa-user"></i></span>
                            </div>
                            <input type="text" name="name" id="name" value="{{$students->name}}" class="form-control border-left-0 pl-0" required>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-600">Address</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light border-right-0"><i class="fas fa-map-marker-alt"></i></span>
                            </div>
                            <input type="text" name="address" id="address" value="{{$students->address}}" class="form-control border-left-0 pl-0" required>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-600">Mobile Number</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light border-right-0"><i class="fas fa-phone-alt"></i></span>
                            </div>
                            <input type="text" name="mobile" id="mobile" value="{{$students->mobile}}" class="form-control border-left-0 pl-0" required>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ url('/students') }}" class="btn btn-light border px-4">Cancel</a>
                        <button type="submit" class="btn btn-warning text-white px-5 shadow-sm font-weight-bold">
                            Update Student <i class="fas fa-sync-alt ml-2"></i>
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
        border-color: #f59e0b; /* Warning color for editing */
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }
</style>

@endsection