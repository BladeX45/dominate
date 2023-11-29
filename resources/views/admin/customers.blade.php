@extends('layouts.app', ['pageSlug' => 'admin.customers'])

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <div class="row">
                <div class="col-md-10">
                    <h4 class="card-title ">Users Table</h4>
                </div>
                <div class="col">

                        <a href="{{-- route('admin.plans.create') --}}" class="btn btn-info btn-round" data-toggle="modal" data-target="#addUser">Add User</a>

                </div>
              </div>
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
    {{-- modal --}}
    <x-modal title="Add User" idModal="addUser" customStyle="modal-lg">
        <x-form action="{{ route('admin.addUser') }}" method="POST">
            @csrf
            <div class="row">
                {{-- hidden role --}}
                <input type="hidden" name="role" value="customer">
                <div class="col-md-6">
                    {{-- username --}}
                    <div class="form-group">
                        <label for="name">Username</label>
                        <input type="text" name="name" id="name" placeholder="username" class="form-control">
                    </div>
                    {{-- firstName --}}
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" name="firstName" id="firstName" placeholder="First Name" class="form-control">
                    </div>
                    {{-- birthDate --}}
                    <div class="form-group">
                        <label for="birthDate">birtday</label>
                        <input type="date" name="birthDate" placeholder="Birth Day" class="form-control" required>
                    </div>
                    {{-- phone --}}
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" placeholder="Phone" class="form-control" required>
                    </div>
                    {{-- gender --}}
                    <label for="gender">Gender</label><br>
                    <div class="d-flex justify-content-between">
                        <div class="male">
                            <input type="radio" id="html" name="gender" value="male">
                            <label for="html">Male</label>
                        </div>
                        <div class="female">
                            <input type="radio" id="female" name="gender" value="female">
                            <label for="female">Female</label>
                        </div>
                        <div class="other">
                            <input type="radio" id="other" name="gender" value="other">
                            <label for="other">Other</label>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                    {{-- email --}}
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="Email" class="form-control">
                    </div>
                    {{-- lastName --}}
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" name="lastName" id="lastName" placeholder="Last Name" class="form-control">
                    </div>
                    {{-- NIK --}}
                    <div class="form-group">
                        <label for="NIN">NIK</label>
                        <input type="text" name="NIN" placeholder="NIN" class="form-control" required>
                    </div>
                    {{-- address --}}
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" placeholder="Address" class="form-control" rows="5" required></textarea>
                    </div>
                </div>
            </div>
            <div class="row">

            </div>
            {{-- firstName --}}

            <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
            </div>
        </x-form>
    </x-modal>
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
