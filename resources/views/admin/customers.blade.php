@extends('layouts.app', ['pageSlug' => 'admin.customers'])

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">Users Table</h4>
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
                  <tbody id="data">
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
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-center">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link" href="#" id="prev">Previous</a></li>
                                <li class="page-item"><a class="page-link" href="#" id="next">Next</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
