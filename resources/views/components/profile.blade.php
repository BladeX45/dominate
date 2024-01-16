<!-- resources/views/components/profile.blade.php -->

<div class="modal-body">
    {{-- @dd($profileData) --}}
    @if ($userData)
        <h5 class="text-dark">{{ $userData->name ?: 'Nama Pengguna Tidak Tersedia' }}</h5>
        <p  class="text-dark">Email: {{ $userData->email ?: 'Email Pengguna Tidak Tersedia' }}</p>
        <!-- Tambahkan informasi profil lainnya sesuai kebutuhan -->
        @if ($userData->roleID == 3)
        @foreach ($profileData as $instructor)
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group bg-white">
                        <label for="instructorName" class="text-dark">Instructor Name</label>
                        <input type="text" class="form-control text-light" id="instructorName" value="{{ $instructor->firstName }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="instructorGender" class="text-dark">Gender</label>
                        <input type="text" class="form-control text-light" id="instructorGender" value="{{ $instructor->gender }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="instructorBirthDate" class="text-dark">Birthdate</label>
                        <input type="text" class="form-control text-light" id="instructorBirthDate" value="{{ $instructor->birthDate }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="instructorAddress" class="text-dark">Address</label>
                        <input type="text" class="form-control text-light" id="instructorAddress" value="{{ $instructor->address }}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="instructorPhone" class="text-dark">Phone Number</label>
                        <input type="text" class="form-control text-light" id="instructorPhone" value="{{ $instructor->phone }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="instructorExperience" class="text-dark">Driving Experiences</label>
                        <input type="text" class="form-control text-light" id="instructorExperience" value="{{ $instructor->drivingExperience }} Tahun" readonly>
                    </div>
                    <div class="form-group">
                        <label for="instructorCertificate" class="text-dark">Certificate</label>
                        <input type="text" class="form-control text-light" id="instructorCertificate" value="{{ $instructor->certificate }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="instructorRating" class="text-dark">Rating</label>
                        <input type="text" class="form-control text-light" id="instructorRating" value="{{ $instructor->rating }}" readonly>
                    </div>
                </div>
            </div>
        @endforeach


        @elseif ($userData->roleID == '2')
        @foreach ($profileData as $customer)
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group bg-white">
                        <label for="firstName" class="text-dark">First Name</label>
                        <input type="text" class="form-control text-light" id="firstName" value="{{ $customer->firstName }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="gender" class="text-dark">Gender</label>
                        <input type="text" class="form-control text-light" id="gender" value="{{ $customer->gender }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="birthDate" class="text-dark">Birth Date</label>
                        <input type="text" class="form-control text-light" id="birthDate" value="{{ $customer->birthDate }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="totalSession" class="text-dark">Total Session</label>
                        <input type="text" class="form-control text-light" id="totalSession" value="{{ $customer->ManualSession + $customer->MaticSession }}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lastName" class="text-dark">Last Name</label>
                        <input type="text" class="form-control text-light" id="lastName" value="{{ $customer->lastName }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="NIN" class="text-dark">NIN</label>
                        <input type="text" class="form-control text-light" id="NIN" value="{{ $customer->NIN }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="text-dark">Phone</label>
                        <input type="text" class="form-control text-light" id="phone" value="{{ $customer->phone }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="address" class="text-dark">Address</label>
                        <input type="text" class="form-control text-light" id="address" value="{{ $customer->address }}" readonly>
                    </div>
                </div>
            </div>
        @endforeach

        @endif
    @else
        <p>Profil pengguna tidak ditemukan.</p>
    @endif
</div>
