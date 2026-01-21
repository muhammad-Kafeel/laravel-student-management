@extends('layout')
@section('content')

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card shadow-sm border-0">
          <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 font-weight-bold text-dark">
              <i class="fas fa-chalkboard-teacher mr-2 text-success"></i>Teacher Management
            </h5>
            @if(Auth::user()->isAdmin())
              <a href="{{ url('/teachers/create') }}" class="btn btn-success shadow-sm">
                <i class="fa fa-plus"></i> Add New Teacher
              </a>
            @endif
          </div>

          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead class="bg-light">
                  <tr>
                    <th class="border-top-0">#</th>
                    <th class="border-top-0">Full Name</th>
                    <th class="border-top-0">Address</th>
                    <th class="border-top-0">Mobile</th>
                    <th class="border-top-0 text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($teachers as $teach)
                    <tr>
                      <td class="px-4 text-muted">{{ $loop->iteration }}</td>
                      <td><strong>{{ $teach->name }}</strong></td>
                      <td>{{ $teach->address }}</td>
                      <td>{{ $teach->mobile }}</td>
                      <td class="text-center">
                        <div class="btn-group" role="group">
                          <a href="{{ url('/teachers/'.$teach->id) }}" class="btn btn-sm btn-outline-info" title="View">
                            <i class="fa fa-eye"></i>
                          </a>

                          @if(Auth::user()->isAdmin())
                            <a href="{{ url('/teachers/'.$teach->id.'/edit') }}" class="btn btn-sm btn-outline-primary" title="Edit">
                              <i class="fa fa-pencil-alt"></i>
                            </a>

                            <form method="POST" action="{{ url('/teachers/'.$teach->id) }}" style="display:inline">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                <i class="fa fa-trash"></i>
                              </button>
                            </form>
                          @endif
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    /* Custom hover effect for rows */
    .table-hover tbody tr:hover {
      background-color: rgba(16, 185, 129, 0.05);
    }

    .btn-group .btn {
      margin: 0 2px;
      border-radius: 4px !important;
    }
  </style>

@endsection
