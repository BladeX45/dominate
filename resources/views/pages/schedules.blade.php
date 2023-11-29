@extends('layouts.app', ['page' => __('Schedules'), 'pageSlug' => 'schedules'])
@section('content')

<div class="row">
    <div class="col-md-12">
        {{-- if any error --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ session('error') }}</strong>
            </div>
        @endif
        {{-- if any success --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session('success') }}</strong>
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h3 class="title">Schedule</h3>
                    {{-- disabled if admin --}}
                    @if (auth()->user()->roleID == 2)
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#schedules">
                            Add Schedule
                        </button>
                    @endif
                </div>
                <div class="row">
                    <div class="container-fluid">
                        <div class="col-md-4">
                            <div class="searchInput">
                                <input type="text" name="search" id="searchInput" class="form-control bg-dark" placeholder="Search Schedule">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if (count($schedules) > 0)
                <div class="card">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Instructor Name</th>
                                    <th scope="col">Tranmission</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Session</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="data">
                                @foreach ($schedules as $schedule)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $schedule->instructor->firstName }} {{ $schedule->instructor->lastName }}</td>
                                        <td>{{ $schedule->car->Transmission }}</td>
                                        <td>{{ date('Y/m/d', strtotime($schedule->date)) }}</td>
                                        <td>{{ $schedule->session }}</td>
                                        <td>{{ $schedule->status }}</td>
                                        {{-- if roleID == 0 | 1 --}}
                                        @if (auth()->user()->roleID == 0 || auth()->user()->roleID == 1)
                                            @if('pending' === $schedule->status )
                                            {{-- cancel button --}}
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#cancelSchedule{{$schedule->id}}">
                                                    {{ __('Cancel')}}
                                                </button>
                                            </td>
                                            <x-modal title="Cancel Schedule" idModal="cancelSchedule{{$schedule->id}}" customStyle="">
                                                <x-form action="{{ route('admin.cancel') }}" method="post">
                                                    {{-- hidden scheduleID --}}
                                                    <input type="hidden" name="scheduleID" value="{{$schedule->id}}">
                                                    {{-- hidden instructorID --}}
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h3 class="text-light">
                                                               {{__('Are you sure you want to cancel this schedule?')}}
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            {{-- Cancel Button --}}
                                                            <button type="submit" class="btn btn-danger">Cancel</button>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {{-- Close Button --}}
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </x-form>
                                            </x-modal>
                                            @else
                                                {{-- if status is done cek nilai --}}
                                                @if ($schedule->status === 'done' || $schedule->status === 'completed')
                                                    <td>
                                                        {{-- penilaian instruktur --}}
                                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#score{{$schedule->id}}">
                                                            Check Score
                                                        </button>
                                                    </td>
                                                @else
                                                    {{-- button cancel disabled --}}
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-sm" disabled>
                                                            {{ __('Cancel')}}
                                                        </button>
                                                    </td>
                                                @endif
                                            @endif
                                        @else
                                            @if ($schedule->status === 'pending')
                                                <td>
                                                    {{-- penilaian instruktur --}}
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#rate" disabled>
                                                        Rate
                                                    </button>
                                                </td>
                                            @elseif ($schedule->status === 'trained')
                                                <td>
                                                    {{-- penilaian instruktur --}}
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#rate" disabled>
                                                        Rate
                                                    </button>
                                                </td>
                                                {{-- need penilaian instruktur --}}
                                            @elseif ($schedule->status === 'need rating')
                                                <td>
                                                    {{-- penilaian instruktur --}}
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#rate{{$schedule->id}}">
                                                        Rate
                                                    </button>
                                                </td>
                                            @elseif ($schedule->status === 'done' || $schedule->status === 'completed')
                                                <td>
                                                    {{-- penilaian instruktur --}}
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#score{{$schedule->id}}">
                                                        Check Score
                                                    </button>
                                                </td>
                                            @else
                                                <td>
                                                    {{-- penilaian instruktur --}}
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#rate" disabled>
                                                        Canceled
                                                    </button>
                                                </td>
                                            @endif
                                        @endif
                                        {{-- pending, trained, completed --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
                @else
                    <p>There are no available schedules.</p>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- if  --}}
@if (count($schedules) > 0)
    @foreach ($schedules as $schedule)
        {{-- modal penilaian instruktur --}}
        <x-modal idModal="rate{{$schedule->id}}" title="Penilaian Instruktur" customStyle="modal-lg">
            <x-form action="{{route('customer.rating')}}" method="post">
                {{-- hidden instructorID --}}
                <input type="hidden" name="instructorID" value="{{ $schedule->instructor->id }}">
                {{-- hidden scheduleID --}}
                <input type="hidden" name="scheduleID" value="{{ $schedule->id }}">
                {{-- input rating 1-10 --}}
                <div class="form-group">
                    <label for="rating">Rating</label>
                    <input type="number" name="rating" id="rating" class="form-control" min="1" max="10" required>
                </div>
                {{-- input comment --}}
                <div class="form-group">
                    <label for="comment">Komentar</label>
                    <textarea name="comment" id="comment" cols="30" rows="10" class="form-control" required></textarea>
                </div>
                {{-- button submit --}}
                <button type="submit" class="btn btn-primary">Simpan</button>
            </x-form>
        </x-modal>
    @endforeach
@endif


<x-modal idModal="schedules" title="Tambah Jadwal" customStyle="">
    <x-form id="schedule-form" action="{{route('customer.creataSchedule')}}" method="post">
        <x-schedules>
            <div id="availability-message"></div>
            <label for="instructor">Choose Instructor</label>
            <select name="instructor" id="instructor" class="form-control" required>
                @foreach ($instructors as $instructor)
                    <option class="bg-primary" value="{{ $instructor->id }}">{{ $instructor->firstName }} {{ $instructor->lastName }}</option>
                @endforeach
            </select>


            <label for="type">Choose Transmission</label>
            <select name="type" id="type" class="form-control" required>
                <option class="bg-primary" value="manual">Manual</option>
                <option class="bg-primary" value="matic">Matic</option>
            </select>

            <label for="date">Date</label>
            <input type="date" name="date" id="date" class="form-control" required>
            <span id="error-message" style="color: red;"></span>

            <label for="session">Pilih Sesi</label>
            <select name="session" id="session" class="form-control" required>
                <option class="bg-primary">--- Choose Session ---</option>
                <option class="bg-primary" value="1">08:00-10:00</option>
                <option class="bg-primary" value="2">10:15-12:15</option>
                <option class="bg-primary" value="3">13:00-15:00</option>
                <option class="bg-primary" value="4">15:00-17:15</option>
            </select>

            <p class="text-danger pt-3 text-center">After submitting, the schedule cannot be canceled!</p>

            <button type="submit" class="btn btn-primary" id="submit-button">Save</button>
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
                        // Tanggapan dari server
                        console.log(response);
                        var availabilityMessage = document.getElementById('availability-message');
                        if (response.isAvailable) {
                            // Jadwal tersedia, tambahkan class 'available' dan hapus class 'booked' (jika ada)
                            availabilityMessage.innerHTML = 'Jadwal tersedia.';
                            availabilityMessage.classList.add('bg');
                            availabilityMessage.classList.add('bg-success');
                            availabilityMessage.classList.remove('bg-danger');
                            $('#submit-button').prop('disabled', false);
                        } else {
                            // Jadwal tidak tersedia, tambahkan class 'booked' dan hapus class 'available' (jika ada)
                            availabilityMessage.innerHTML = 'Jadwal sudah dipesan.';
                            availabilityMessage.classList.add('bg');
                            availabilityMessage.classList.add('bg-danger');
                            availabilityMessage.classList.remove('bg-success');
                            document.getElementById("submit-button").disabled = true;
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
            <div class="col-md-12">
                {{-- nama customer --}}
                <p class="text-primary">Nama Peserta : {{$score->customer->firstName}} {{$score->customer->lastName}}</p>
                {{-- nama instructor --}}
                <p class="text-primary">Nama Instruktur : {{$score->instructor->firstName}} {{$score->instructor->lastName}}</p>
                {{-- tanggal latihan --}}
                <p class="text-primary">Tanggal Latihan : {{$score->schedule->date}}, Sesi : {{$score->schedule->session}}</p>
                {{-- score : theoryKnowledge, practicalDriving, hazardPerception, trafficRulesCompliance, confidenceAndAttitude, overallAssessment, overallAssessment, dalam bahasa indonesia --}}
                <p class="text-primary">Nilai : </p>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="theoryKnowledge{{$score->id}}" class="text-primary">{{ __('Theory Knowledge Score')}}</label><br>
                            <input type="number" class="w-100" id="theoryKnowledge{{$score->id}}" name="theoryKnowledge" readonly value="{{$score->theoryKnowledge}}"><br>
                        </div>
                        <div class="form-group">
                            <label for="practicalDriving{{$score->id}}" class="text-primary">{{ __('Practical Driving Score')}}</label><br>
                            <input type="number" class="w-100" id="practicalDriving{{$score->id}}" name="practicalDriving" readonly value="{{$score->practicalDriving}}"><br>
                        </div>
                        <div class="form-group">
                            <label for="hazardPerception{{$score->id}}" class="text-primary">{{ __('Hazard Perception Score')}}</label><br>
                            <input type="number" class="w-100" id="hazardPerception{{$score->id}}" name="hazardPerception" readonly value="{{$score->hazardPerception}}"><br>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="trafficRulesCompliance{{$score->id}}" class="text-primary">{{ __('Traffic Rules Compliance Score')}}</label><br>
                            <input type="number" class="w-100" id="trafficRulesCompliance{{$score->id}}" name="trafficRulesCompliance" readonly value="{{$score->trafficRulesCompliance}}"><br>
                        </div>
                        <div class="form-group">
                            <label for="confidenceAndAttitude{{$score->id}}" class="text-primary">{{ __('Confidence and Attitude Score')}}</label><br>
                            <input type="number" class="w-100" id="confidenceAndAttitude{{$score->id}}" name="confidenceAndAttitude" readonly value="{{$score->confidenceAndAttitude}}"><br>
                        </div>
                        <div class="form-group">
                            <label for="overallAssessment{{$score->id}}" class="text-primary">{{ __('Overall Score')}}</label><br>
                            <input type="number" class="w-100" id="overallAssessment{{$score->id}}" name="overallAssessment" readonly value="{{$score->overallAssessment}}"><br>
                        </div>
                    </div>
                </div>

                {{-- additional comment --}}
                <p class="text-primary">Comment : {{$score->additionalComment}}</p>
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
<script>

    var searchInput = document.getElementById("searchInput");
        // Dapatkan semua baris (tr) dalam tabel
        var rows = document.querySelectorAll("tbody tr");

        // Tambahkan event listener untuk input pencarian
        searchInput.addEventListener("input", function () {
            var searchText = searchInput.value.toLowerCase();

            // Iterasi melalui setiap baris dalam tabel
            rows.forEach(function (row) {
                // Dapatkan sel di dalam baris
                var cells = row.getElementsByTagName("td");
                var shouldShow = false;

                // Periksa apakah teks pencarian ada dalam setiap sel
                for (var i = 0; i < cells.length; i++) {
                    var cellText = cells[i].textContent.toLowerCase();
                    if (cellText.includes(searchText)) {
                        shouldShow = true;
                        break;
                    }
                }

                // Tampilkan atau sembunyikan baris berdasarkan hasil pencarian
                if (shouldShow) {
                    row.style.display = "table-row";
                } else {
                    row.style.display = "none";
                }
            });
        });
</script>

{{-- script ajax get data from  --}}
@endsection
