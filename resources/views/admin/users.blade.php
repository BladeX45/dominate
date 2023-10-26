@extends('layouts.app', ['pageSlug' => 'admin.users'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <div class="row">
                            <div class="col-10 d-flex">
                                Instructor List
                            </div>
                            <div class="col">
                                <a href="{{-- route('admin.plans.create') --}}" class="btn btn-info btn-round" data-toggle="modal" data-target="#addUser">Add User</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="container-fluid">
                                <div class="col-md-4">
                                    <div class="searchInput">
                                        <input type="text" name="search" id="searchInput" class="form-control" placeholder="Search Transaction">
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
                                        Role
                                    </th>
                                    <th>
                                        Action
                                    </th>
                                </thead>
                                <tbody>
                                    @php
                                    $increment = 1; // Inisialisasi nomor baris (increment) awal
                                    @endphp

                                    @foreach ($data as $user)
                                    <tr>
                                        <td>
                                            {{ $increment }}
                                        </td>
                                        <td>
                                            {{ $user->userName }}
                                        </td>
                                        <td>
                                            {{ $user->userEmail }}
                                        </td>
                                        <td>
                                            {{ $user->roleName }}
                                        </td>
                                        <td>
                                            <a href="#" rel="tooltip" class="btn btn-info btn-sm btn-round btn-icon"
                                               data-toggle="modal" data-target="#profile{{ $user->userID }}" data-placement="top" title="Tampilkan Profil"
                                               data-userid="{{ $user->userID }}">
                                               <i class="tim-icons icon-single-02"></i>
                                           </a>
                                       </td>
                                   </tr>
                                   {{-- Increment nomor baris --}}
                                   @php
                                   $increment++;
                                   @endphp
                                    <x-modal title="Profile" idModal="profile{{ $user->userID }}" customStyle="">
                                        <x-profile idUser="{{ $user->userID }}" />
                                    </x-modal>
                                   @endforeach
                               </tbody>
                           </table>
                           <p id="noDataFoundMessage" style="display: none; color: red;">Data not Found</p>
                           <nav aria-label="...">
                               <ul class="pagination">
                                   <!-- Tombol Previous -->
                                   @if ($data->onFirstPage())
                                   <li class="page-item disabled">
                                       <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Sebelumnya</a>
                                   </li>
                                   @else
                                   <li class="page-item">
                                       <a class="page-link" href="{{ $data->previousPageUrl() }}" tabindex="-1">Sebelumnya</a>
                                   </li>
                                   @endif
                                   <!-- Tombol halaman -->
                                   @foreach ($data->getUrlRange(1, $data->lastPage()) as $page => $url)
                                   <li class="page-item{{ ($data->currentPage() == $page) ? ' active' : '' }}">
                                       <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                   </li>
                                   @endforeach
                                   <!-- Tombol Next -->
                                   @if ($data->hasMorePages())
                                   <li class="page-item">
                                       <a class="page-link" href="{{ $data->nextPageUrl() }}">Selanjutnya</a>
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

<x-modal title="Add User" idModal="addUser" customStyle="">
    <x-form action="{{ route('admin.addUser') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="Name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" placeholder="Email" class="form-control" required>
        </div>
        {{-- role = Instructor --}}
        <div class="form-group">
            <label for="role">Role</label>
            {{-- default value instructor --}}
            <input type="text" name="role" placeholder="Instructor" value="Instructor" class="form-control" readonly>
        </div>
        {{-- password --}}
        <div class="form-group">
            <label for="password">Password</label>
            <input type="text" name="password" placeholder="Password" class="form-control" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </x-form>
</x-modal>


<script>
    // Tangkap data dari instructors
    let instructors = {!! json_encode($instructors) !!};

    // Tambahkan event listener untuk tombol "Tampilkan Profil"
    const profileButtons = document.querySelectorAll('.btn-info[data-toggle="modal"]');
    profileButtons.forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-userid');
            const profileModal = document.getElementById('profile');
            const profileComponent = profileModal.querySelector('x-profile');
            profileComponent.setAttribute('idUser', userId);
        });
    });
</script>
@endsection
