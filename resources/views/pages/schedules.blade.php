@extends('layouts.app', ['page' => __('Schedules'), 'pageSlug' => 'schedules'])

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card bg-primary">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h3 class="title">Jadwal</h3>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#schedules">
                        Tambah Jadwal
                    </button>
                </div>
            </div>
            <div class="card-body">
                @if (count($schedules) > 0)
                <div class="card">
                    <table class="table">
                        {{-- alert error  --}}
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{ session('error') }}</strong>
                            </div>
                        @endif
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Instuktur</th>
                                <th scope="col">Manual/Matic</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Sesi</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schedules as $schedule)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $schedule->instructor->firstName }} {{ $schedule->instructor->lastName }}</td>
                                    <td>{{ $schedule->carType }}</td>
                                    <td>{{ $schedule->carID}}</td>
                                    <td>{{ $schedule->date }}</td>
                                    <td>{{ $schedule->status }}</td>
                                    {{-- pending, trained, completed --}}
                                    @if ($schedule->status === 'pending')
                                        <td>
                                            {{-- penilaian instruktur --}}
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#rate" disabled>
                                                Penilaian
                                            </button>
                                        </td>
                                    @elseif ($schedule->status === 'trained')
                                        <td>
                                            {{-- penilaian instruktur --}}
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#rate" disabled>
                                                Penilaian
                                            </button>
                                        </td>
                                        {{-- need penilaian instruktur --}}
                                    @elseif ($schedule->status === 'need rating')
                                        <td>
                                            {{-- penilaian instruktur --}}
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#rate">
                                                Penilaian
                                            </button>
                                        </td>
                                    @else
                                        <td>
                                            {{-- penilaian instruktur --}}
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#score{{$schedule->id}}">
                                                Cek Nilai
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <p>Tidak ada jadwal yang tersedia.</p>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- if  --}}
@if (count($schedules) > 0)

{{-- modal penilaian instruktur --}}
<x-modal idModal="rate" title="Penilaian Instruktur" customStyle="modal-lg">
    <x-form action="{{route('customer.rating')}}" method="post">
        {{-- hidden instructorID --}}
        <input type="hidden" name="instructorID" value="{{ $schedule->instructor->id }}">
        {{-- hidden scheduleID --}}
        <input type="hidden" name="scheduleID" value="{{ $schedule->id }}">
        {{-- input rating 1-10 --}}
        <div class="form-group">
            <label for="rating">Rating</label>
            <input type="number" name="rating" id="rating" class="form-control" min="1" max="10">
        </div>
        {{-- input comment --}}
        <div class="form-group">
            <label for="comment">Komentar</label>
            <textarea name="comment" id="comment" cols="30" rows="10" class="form-control"></textarea>
        </div>
        {{-- button submit --}}
        <button type="submit" class="btn btn-primary">Simpan</button>

    </x-form>
</x-modal>

@endif


<x-modal idModal="schedules" title="Tambah Jadwal" customStyle="">
    <x-form id="schedule-form" action="{{route('customer.creataSchedule')}}" method="post">
        <x-schedules>
            <div id="availability-message"></div>
            <label for="instructor">Pilih Instruktur</label>
            <select name="instructor" id="instructor" class="form-control">
                <option class="bg-primary" value="">Pilih Instruktur</option>
                @foreach ($instructors as $instructor)
                    <option class="bg-primary" value="{{ $instructor->id }}">{{ $instructor->firstName }} {{ $instructor->lastName }}</option>
                @endforeach
            </select>

            <label for="type">Pilih Tipe</label>
            <select name="type" id="type" class="form-control">
                <option class="bg-primary" value="manual">Manual</option>
                <option class="bg-primary" value="matic">Matic</option>
            </select>

            <label for="date">Pilih Tanggal</label>
            <input type="date" name="date" id="date" class="form-control">
            <span id="error-message" style="color: red;"></span>

            <label for="session">Pilih Sesi</label>
            <select name="session" id="session" class="form-control">
                <option class="bg-primary">--- Pilih Sesi ---</option>
                <option class="bg-primary" value="1">08:00-09:45</option>
                <option class="bg-primary" value="2">10:00-11:45</option>
                <option class="bg-primary" value="3">14:00-15:45</option>
                <option class="bg-primary" value="4">16:00-17:45</option>
                <option class="bg-primary" value="5">19:00-30:45</option>
            </select>

            <p class="text-danger pt-3 text-center">Setelah melakukan submit, jadwal tidak dapat dibatalkan!</p>

            <button type="submit" class="btn btn-primary" id="submit-button">Simpan Jadwal</button>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            {{-- script checking data input user dengan data schedule --}}
            <script>
                $('#session').change(function () {
                // Ambil nilai dari dropdowns
                var instructorId = $('#instructor').val();
                var date = $('#date').val();
                var session = $('#session').val();
                var type = $('#type').val();

                // Kirim permintaan AJAX ke server untuk memeriksa ketersediaan jadwal
                $.ajax({
                    type: 'post',
                    url: '{{ route("check-availability") }}',
                    data: {
                        _token:'{{ csrf_token() }}', // Pastikan Anda menggunakan token CSRF dengan benar
                        instructor: instructorId,
                        date: date,
                        session: session,
                        type: type
                    },
                    success: function (response) {
                        var availabilityMessage = document.getElementById('availability-message');
                        if (response.isAvailable) {
                            // Jadwal tersedia, tambahkan class 'available' dan hapus class 'booked' (jika ada)
                            availabilityMessage.innerHTML = 'Jadwal tersedia.';
                            availabilityMessage.classList.add('bg');
                            availabilityMessage.classList.add('bg-success');
                            availabilityMessage.classList.remove('bg-danger');
                            console.log(response);
                        } else {
                            // Jadwal tidak tersedia, tambahkan class 'booked' dan hapus class 'available' (jika ada)
                            availabilityMessage.innerHTML = 'Jadwal sudah dipesan.';
                            availabilityMessage.classList.add('bg');
                            availabilityMessage.classList.add('bg-danger');
                            availabilityMessage.classList.remove('bg-success');
                            console.log(response);
                        }
                    },

                    error: function () {
                        // Penanganan kesalahan jika diperlukan
                    }
                });
            });

            document.getElementById("date").addEventListener("input", function () {
                var selectedDate = new Date(this.value);
                var currentDate = new Date();

                if (selectedDate < currentDate) {
                    document.getElementById("error-message").textContent = "Tanggal tidak boleh kurang dari tanggal sekarang.";
                    document.getElementById("date").setCustomValidity("Invalid");
                } else {
                    document.getElementById("error-message").textContent = "";
                    document.getElementById("date").setCustomValidity("");
                }
            });

            </script>
        </x-schedules>
    </x-form>
</x-modal>

{{-- x-modal for score customer --}}
@foreach ($scores as $score )
    <x-modal idModal="score{{$score->scheduleID}}" title="Nilai Peserta" customStyle="modal-lg">
        {{--  --}}
        <div class="row">
            <div class="col-md-8">
                {{-- nama customer --}}
                <p class="text-primary">Nama Peserta : {{$score->customer->firstName}} {{$score->customer->lastName}}</p>
                {{-- nama instructor --}}
                <p class="text-primary">Nama Instruktur : {{$score->instructor->firstName}} {{$score->instructor->lastName}}</p>
                {{-- tanggal latihan --}}
                <p class="text-primary">Tanggal Latihan : {{$score->schedule->date}}, Sesi : {{$score->schedule->session}}</p>
                {{-- score : theoryKnowledge, practicalDriving, hazardPerception, trafficRulesCompliance, confidenceAndAttitude, overallAssessment, overallAssessment, dalam bahasa indonesia --}}
                <p class="text-primary">Nilai : </p>
                <ul>
                    <li>Pengetahuan Teori : {{$score->theoryKnowledge}}</li>
                    <li>Praktik Mengemudi : {{$score->practicalDriving}}</li>
                    <li>Persepsi Bahaya : {{$score->hazardPerception}}</li>
                    <li>Kepatuhan Aturan Lalu Lintas : {{$score->trafficRulesCompliance}}</li>
                    <li>Kepercayaan Diri dan Sikap : {{$score->confidenceAndAttitude}}</li>
                    <li>Penilaian Keseluruhan : {{$score->overallAssessment}}</li>
                </ul>

                {{-- additional comment --}}
                <p class="text-primary">Komentar : {{$score->additionalComment}}</p>
                {{-- if isFinal -> 1 && overallAssessment 70> then show generate certificate  --}}
                @if ($score->isFinal === 1 && $score->overallAssessment >= 70)
                    {{-- form button generate certificate --}}
                    <form action="{{route('customer.generateCertificate')}}" method="post">
                        @csrf
                        {{-- hidden scheduleID --}}
                        <input type="hidden" name="scheduleID" value="{{$score->scheduleID}}">
                        {{-- hidden customerID --}}
                        <input type="hidden" name="customerID" value="{{$score->customerID}}">
                        {{-- hidden instructorID --}}
                        <input type="hidden" name="instructorID" value="{{$score->instructorID}}">
                        {{-- hidden scoreID --}}
                        <input type="hidden" name="scoreID" value="{{$score->id}}">
                        {{-- button generate certificate --}}
                        <button type="submit" class="btn btn-primary">Generate Certificate</button>
                    </form>
                @endif
            </div>
        </div>
    </x-modal>
@endforeach


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


{{-- script ajax get data from  --}}
@endsection
