@extends('layouts.app', ['pageSlug' => 'Instructors'])

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
                            <div class="col-10 d-flex">
                                Instructor List
                            </div>
                            <div class="col">
                                <a href="{{-- route('admin.plans.create') --}}" class="btn btn-primary btn-round" data-toggle="modal" data-target="#addUser">Add User</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="container-fluid">
                                <div class="col-md-4">
                                    <div class="searchInput">
                                        <input type="text" name="search" id="searchInput" class="form-control text-dark" placeholder="Search Instructor">
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
<x-modal title="Add User" idModal="addUser" customStyle="modal-lg">
    <x-form action="{{ route('admin.addUser') }}" method="post">
        {{ csrf_field() }}
        <div class="row">
            <input type="hidden" name="role" placeholder="Instructor" value="Instructor" class="form-control" hidden>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name">username</label>
                    <input type="text" name="name" placeholder="Name" class="form-control text-dark" required>
                </div>
                <div class="form-group">
                    {{-- firstName --}}
                    <label for="firstName">First Name</label>
                    <input type="text" name="firstName" placeholder="First Name" class="form-control text-dark" required>
                </div>
                {{-- role = Instructor --}}
                <div class="form-group">
                    <label for="birthDate">birtday</label>
                    <input type="date" name="birthDate" placeholder="Birth Day" class="form-control text-dark" required>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-7">
                            <label for="gender">Gender</label><br>
                            <input type="radio" id="html" name="gender" value="male">
                            <label for="html">Male</label>
                            <input type="radio" id="css" name="gender" value="female">
                            <label for="css">Female</label>
                        </div>
                        <div class="col-md-5">
                            {{-- drivingExperience --}}
                            <label for="drivingExperience">Exp</label>
                            <input type="text" name="drivingExperience" placeholder="Driving Experience" class="form-control text-dark" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {{-- phone --}}
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" placeholder="Phone" class="form-control text-dark" required>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">

                    <label for="email">Email</label>
                    <input type="text" name="email" placeholder="Email" class="form-control text-dark" required>
                </div>
                <div class="form-group">
                    {{-- lastName --}}
                    <label for="lastName">Last Name</label>
                    <input type="text" name="lastName" placeholder="Last Name" class="form-control text-dark" required>
                </div>
                <div class="form-group">
                    {{-- NIN --}}
                    <label for="NIN">NIK</label>
                    <input type="text" name="NIN" placeholder="NIN" class="form-control text-dark" required>
                </div>
                <div class="form-group">
                    {{-- address --}}
                    <label for="address">Address</label>
                    <textarea type="textarea" name="address" placeholder="Address" class="form-control text-dark" required></textarea>
            </div>
            <div class="input-group mb-3">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="certificate" id="certificate" aria-describedby="inputGroupFileAddon01" onchange="updateFileName()">
                    <label class="custom-file-label bg-dark" for="certificate" id="fileLabel">Choose file</label>
                </div>
            </div>
        </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>

    </x-form>
</x-modal>
</div>






<script>
    function updateFileName() {
        // Get the input element and the label element
        var input = document.getElementById('certificate');
        var label = document.getElementById('fileLabel');

        // Set the label text to the selected file name
        label.innerHTML = input.files[0].name;
    }
</script>


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
