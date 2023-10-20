<!-- resources/views/components/profile.blade.php -->

<div class="modal-body">
    {{-- @dd($profileData) --}}
    @if ($userData)
        <h5>{{ $userData->name ?: 'Nama Pengguna Tidak Tersedia' }}</h5>
        <p  class="text-light">Email: {{ $userData->email ?: 'Email Pengguna Tidak Tersedia' }}</p>
        <!-- Tambahkan informasi profil lainnya sesuai kebutuhan -->
        @if ($userData->roleID == 3)
        @foreach ($profileData as $instructor)
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="instructorName">Instructor Name</label>
                        <input type="text" class="form-control" id="instructorName" value="{{ $instructor->firstName }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="instructorGender">Gender</label>
                        <input type="text" class="form-control" id="instructorGender" value="{{ $instructor->gender }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="instructorBirthDate">Birthdate</label>
                        <input type="text" class="form-control" id="instructorBirthDate" value="{{ $instructor->birthDate }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="instructorAddress">Address</label>
                        <input type="text" class="form-control" id="instructorAddress" value="{{ $instructor->address }}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="instructorPhone">Phone Number</label>
                        <input type="text" class="form-control" id="instructorPhone" value="{{ $instructor->phone }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="instructorExperience">Driving Experiences</label>
                        <input type="text" class="form-control" id="instructorExperience" value="{{ $instructor->drivingExperience }} Tahun" readonly>
                    </div>
                    <div class="form-group">
                        <label for="instructorCertificate">Certificate</label>
                        <input type="text" class="form-control" id="instructorCertificate" value="{{ $instructor->certificate }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="instructorRating">Rating</label>
                        <input type="text" class="form-control" id="instructorRating" value="{{ $instructor->rating }}" readonly>
                    </div>
                </div>
            </div>
        @endforeach


        @elseif ($userData->roleID == '2')
        @foreach ($profileData as $customer)
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" class="form-control" id="firstName" value="{{ $customer->firstName }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <input type="text" class="form-control" id="gender" value="{{ $customer->gender }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="birthDate">Birth Date</label>
                        <input type="text" class="form-control" id="birthDate" value="{{ $customer->birthDate }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="totalSession">Total Session</label>
                        <input type="text" class="form-control" id="totalSession" value="{{ $customer->ManualSession + $customer->MaticSession }}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" class="form-control" id="lastName" value="{{ $customer->lastName }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="NIN">NIN</label>
                        <input type="text" class="form-control" id="NIN" value="{{ $customer->NIN }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" value="{{ $customer->phone }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" value="{{ $customer->address }}" readonly>
                    </div>
                </div>
            </div>
        @endforeach

        @endif
    @else
        <p>Profil pengguna tidak ditemukan.</p>
    @endif
</div>
