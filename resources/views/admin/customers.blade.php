@extends('layouts.app', ['pageSlug' => 'admin.customers'])

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">Users Table</h4>
              <p class="card-category"> Here is a subtitle for this table</p>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                      ID
                    </th>
                    <th>
                      Name
                    </th>
                    <th>
                      Email
                    </th>
                    <th>
                      Role
                    </th>
                    <th>
                      Action
                    </th>
                  </thead>
                  <tbody>
                    @foreach ($users as $user)
                    <tr>
                      <td>
                        {{ $user->id }}
                      </td>
                      <td>
                        {{ $user->name }}
                      </td>
                      <td>
                        {{ $user->email }}
                      </td>
                      <td>
                        {{ $user->roleID }}
                      </td>
                      <td>
                        <button type="button" rel="tooltip" class="btn btn-info btn-sm btn-round btn-icon">
                            <i class="tim-icons icon-single-02"></i>
                        </button>
                        <button type="button" rel="tooltip" class="btn btn-success btn-sm btn-round btn-icon">
                            <i class="tim-icons icon-settings"></i>
                        </button>
                        <button type="button" rel="tooltip" class="btn btn-danger btn-sm btn-round btn-icon">
                            <i class="tim-icons icon-simple-remove"></i>
                        </button>
                      </td>
                    </tr>
                    {{--  --}}
                    @endforeach
                  </tbody>
                </table>
                <nav aria-label="...">
                    <ul class="pagination">
                      <!-- Tombol Previous -->
                      @if ($users->onFirstPage())
                      <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Sebelumnya</a>
                      </li>
                      @else
                      <li class="page-item">
                        <a class="page-link" href="{{ $users->previousPageUrl() }}" tabindex="-1">Sebelumnya</a>
                      </li>
                      @endif

                      <!-- Tombol halaman -->
                      @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                      <li class="page-item{{ ($users->currentPage() == $page) ? ' active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                      </li>
                      @endforeach

                      <!-- Tombol Next -->
                      @if ($users->hasMorePages())
                      <li class="page-item">
                        <a class="page-link" href="{{ $users->nextPageUrl() }}">Selanjutnya</a>
                      </li>
                      @else
                      <li class="page-item disabled">
                        <a class="page-link" href="#">Selanjutnya</a>
                      </li>
                      @endif
                    </ul>
                  </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
    <script src="{{ asset('black') }}/js/plugins/chartjs.min.js"></script>
    <script>
        $(document).ready(function() {
          demo.initDashboardPageCharts();
        });
    </script>
@endpush
