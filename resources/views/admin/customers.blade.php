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
              <div class="row">
                <div class="container-fluid">
                    <div class="col-md-4">
                        <div class="searchInput">
                            <input type="text" name="search" id="searchInput" class="form-control" placeholder="Customer Search">
                        </div>
                    </div>
                </div>
            </div>
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
                        <a href="#" rel="tooltip" class="btn btn-info btn-sm btn-round btn-icon"
                        data-toggle="modal" data-target="#customer{{ $user->id }}" data-placement="top" title="Data Customer"
                        data-userID="{{ $user->id }}">
                        <i class="tim-icons icon-single-02"></i>
                        </a>
                    </td>
                    <x-modal title="Data Customer" idModal="customer{{ $user->id }}" customStyle="modal-xl">
                        <x-profile idUser="{{ $user->id }}" />
                    </x-modal>
                    </tr>
                    {{--  --}}
                    @endforeach
                  </tbody>
                </table>
                <p id="noDataFoundMessage" style="display: none; color: red;">Data not Found</p>
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
