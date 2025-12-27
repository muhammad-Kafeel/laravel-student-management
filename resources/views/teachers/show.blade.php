@extends('layout')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-7">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/teachers') }}">Teacher</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Teacher Profile</li>
                </ol>
            </nav>
            <a href="{{ url('/teachers/'.$teacher->id.'/edit') }}" class="btn btn-primary btn-sm px-3 shadow-sm">
                <i class="fas fa-edit mr-1"></i> Edit Profile
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary py-5 text-center position-relative" style="border-radius: 12px 12px 0 0;">
                <div class="position-absolute w-100" style="bottom: -40px; left: 0;">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($teacher->name) }}&background=f8fafc&color=2563eb&size=80" 
                         class="rounded-circle border border-white shadow" 
                         alt="Avatar"
                         style="width: 80px; height: 80px; border-width: 4px !important;">
                </div>
            </div>

            <div class="card-body pt-5 mt-3 px-4 pb-5">
                <div class="text-center mb-5">
                    <h3 class="font-weight-bold mb-1">{{ $teacher->name }}</h3>
                    <p class="text-muted small"><i class="fas fa-id-badge mr-1"></i> Student ID: #{{ $teacher->id }}</p>
                </div>

                <div class="row">
                    <div class="col-sm-6 mb-4">
                        <div class="p-3 bg-light rounded shadow-sm h-100">
                            <label class="text-muted small font-weight-bold text-uppercase mb-1 d-block">Contact Number</label>
                            <div class="h6 mb-0 font-weight-bold text-dark">
                                <i class="fas fa-phone-alt text-primary mr-2"></i> {{ $teacher->mobile }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-4">
                        <div class="p-3 bg-light rounded shadow-sm h-100">
                            <label class="text-muted small font-weight-bold text-uppercase mb-1 d-block">Location</label>
                            <div class="h6 mb-0 font-weight-bold text-dark text-truncate">
                                <i class="fas fa-map-marker-alt text-primary mr-2"></i> {{ $teacher->address }}
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4 opacity-50">

                <div class="row text-center">
                    <div class="col-4">
                        <div class="small text-muted mb-1">Status</div>
                        <span class="badge badge-pill badge-success px-3 py-2">Active</span>
                    </div>
                    <div class="col-4 border-left border-right">
                        <div class="small text-muted mb-1">Joined Date</div>
                        <div class="font-weight-bold small text-dark">{{ $teacher->created_at->format('d M, Y') }}</div>
                    </div>
                    <div class="col-4">
                        <div class="small text-muted mb-1">Courses</div>
                        <div class="font-weight-bold small text-dark">0 Enrolled</div>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-white border-top-0 pb-4 px-4 text-center">
                <a href="{{ url('/teachers') }}" class="btn btn-outline-secondary btn-sm px-4">
                    <i class="fas fa-arrow-left mr-2"></i> Back to List
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .breadcrumb-item a { color: var(--primary-color); text-decoration: none; font-weight: 500; }
    .breadcrumb-item.active { color: #64748b; font-weight: 500; }
    .bg-light { background-color: #f1f5f9 !important; }
    .badge-soft-success { background-color: #dcfce7; color: #15803d; }
</style>

@endsection