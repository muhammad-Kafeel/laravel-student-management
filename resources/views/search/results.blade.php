@extends('layout')

@section('content')

{{-- Page Header --}}
<div class="mb-4">
  <h4 class="font-weight-bold">
    Search Results
    <span class="text-muted" style="font-size: 16px; font-weight: 400;">
      for "<span class="text-primary">{{ $query }}</span>"
    </span>
  </h4>
  <p class="text-muted mb-0">
    Found <strong>{{ $totalResults }}</strong> result(s) across Students, Teachers, and Courses.
  </p>
</div>

{{-- ==================== NO RESULTS ==================== --}}
@if($totalResults === 0)
  <div class="text-center py-5">
    <i class="fas fa-search fa-3x text-muted mb-3"></i>
    <h5 class="text-muted">No results found for "{{ $query }}"</h5>
    <p class="text-muted">Try searching with a different keyword.</p>
  </div>
@endif

{{-- ==================== STUDENTS ==================== --}}
@if($students->count() > 0)
  <div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-bottom d-flex align-items-center">
      <i class="fas fa-user-graduate text-primary mr-2"></i>
      <h6 class="mb-0 font-weight-bold">
        Students <span class="badge badge-primary ml-1">{{ $students->count() }}</span>
      </h6>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="thead-light">
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Address</th>
              <th>Mobile</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($students as $student)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mr-2"
                         style="width:32px; height:32px; font-size:13px; flex-shrink:0;">
                      {{ strtoupper(substr($student->name, 0, 1)) }}
                    </div>
                    {{-- Highlight the matched keyword --}}
                    {!! preg_replace('/(' . preg_quote($query, '/') . ')/i', '<mark>$1</mark>', e($student->name)) !!}
                  </div>
                </td>
                <td>{!! preg_replace('/(' . preg_quote($query, '/') . ')/i', '<mark>$1</mark>', e($student->address)) !!}</td>
                <td>{{ $student->mobile }}</td>
                <td>
                  <a href="{{ url('/students/' . $student->id) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-eye"></i> View
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endif

{{-- ==================== TEACHERS ==================== --}}
@if($teachers->count() > 0)
  <div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-bottom d-flex align-items-center">
      <i class="fas fa-chalkboard-teacher text-success mr-2"></i>
      <h6 class="mb-0 font-weight-bold">
        Teachers <span class="badge badge-success ml-1">{{ $teachers->count() }}</span>
      </h6>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="thead-light">
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Address</th>
              <th>Mobile</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($teachers as $teacher)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center mr-2"
                         style="width:32px; height:32px; font-size:13px; flex-shrink:0;">
                      {{ strtoupper(substr($teacher->name, 0, 1)) }}
                    </div>
                    {!! preg_replace('/(' . preg_quote($query, '/') . ')/i', '<mark>$1</mark>', e($teacher->name)) !!}
                  </div>
                </td>
                <td>{!! preg_replace('/(' . preg_quote($query, '/') . ')/i', '<mark>$1</mark>', e($teacher->address)) !!}</td>
                <td>{{ $teacher->mobile }}</td>
                <td>
                  <a href="{{ url('/teachers/' . $teacher->id) }}" class="btn btn-sm btn-outline-success">
                    <i class="fas fa-eye"></i> View
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endif

{{-- ==================== COURSES ==================== --}}
@if($courses->count() > 0)
  <div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-bottom d-flex align-items-center">
      <i class="fas fa-book text-warning mr-2"></i>
      <h6 class="mb-0 font-weight-bold">
        Courses <span class="badge badge-warning ml-1">{{ $courses->count() }}</span>
      </h6>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="thead-light">
            <tr>
              <th>#</th>
              <th>Course Name</th>
              <th>Syllabus</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($courses as $course)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center mr-2"
                         style="width:32px; height:32px; font-size:13px; flex-shrink:0;">
                      {{ strtoupper(substr($course->name, 0, 1)) }}
                    </div>
                    {!! preg_replace('/(' . preg_quote($query, '/') . ')/i', '<mark>$1</mark>', e($course->name)) !!}
                  </div>
                </td>
                <td>{!! preg_replace('/(' . preg_quote($query, '/') . ')/i', '<mark>$1</mark>', e(\Illuminate\Support\Str::limit($course->syllabus, 80))) !!}</td>
                <td>
                  <a href="{{ url('/courses/' . $course->id) }}" class="btn btn-sm btn-outline-warning">
                    <i class="fas fa-eye"></i> View
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endif

@endsection
