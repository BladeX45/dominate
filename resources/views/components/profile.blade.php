<!-- resources/views/components/profile.blade.php -->

<div class="modal-body">
    @if ($userData)
        <h5>{{ $userData->name ?: 'Nama Pengguna Tidak Tersedia' }}</h5>
        <p>Email: {{ $userData->email ?: 'Email Pengguna Tidak Tersedia' }}</p>
        <!-- Tambahkan informasi profil lainnya sesuai kebutuhan -->
        @if ($userData->roleID == '3')
            @foreach ($profileData as $instructor)
                <p>Nama Instruktur: {{ $instructor->firstName }}</p>
                <p>Jenis Kelamin: {{ $instructor->gender }}</p>
                <p>Tanggal Lahir: {{ $instructor->birthDate }}</p>
                <p>Alamat: {{ $instructor->address }}</p>
                <p>Telepon: {{ $instructor->phone }}</p>
                <p>Pengalaman Mengemudi: {{ $instructor->drivingExperience }} Tahun</p>
                <p>Sertifikat: {{ $instructor->certificate }}</p>
                <p>Rating: {{ $instructor->rating }}</p>
                <!-- Tambahkan informasi lainnya tentang instruktur -->
            @endforeach
        @elseif ($userData->roleID == '2')
            <p>Nama Pelanggan: {{ $profileData->firstName }}</p>
            <!-- Tampilkan informasi lainnya tentang pelanggan -->
        @endif
    @else
        <p>Profil pengguna tidak ditemukan.</p>
    @endif
</div>
