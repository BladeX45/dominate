@extends('layouts.app', ['page' => __('Schedules'), 'pageSlug' => 'instructor.schedules'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="card bg-primary">
                    <div class="card-header title">
                        <h3 class="title">
                            <i class="tim-icons icon-calendar-60 text-primary"></i> {{ __('Schedules') }}
                        </h3>
                    </div>
                    <div class="row">
                        <div class="container-fluid">
                            <div class="col-md-4">
                                <div class="searchInput">
                                    <input type="text" name="search" id="searchInput" class="form-control" placeholder="Cari Jadwal">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">{{ __('Nama Customer') }}</th>
                                <th scope="col">{{ __('Waktu/Sesi') }}</th>
                                <th scope="col">{{ __('Mobil') }}</th>
                                <th scope="col">{{ __('status') }}</th>
                                <th scope="col">{{ __('Aksi')}}</th>
                              </tr>
                            </thead>
                            <tbody>
                                {{-- if schedules is exists --}}
                                @if($schedules)
                                @foreach ($schedules as $schedule)
                                <tr>
                                    <td scope="row">{{$schedule->customer->firstName}} {{$schedule->customer->lastName}}</td>
                                    <td class="fs-2">{{$schedule->date}}, Sesi : {{$schedule->session}} </td>
                                    <td class="fs-2">{{$schedule->car->carName}}</td>
                                    <td class="fs-2">{{$schedule->status}}</td>
                                    {{-- if status === success then disable button --}}
                                        @if('trained' === $schedule->status )
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#rate{{$schedule->id}}" >
                                                    Penilaian
                                                </button>
                                            </td>
                                        @elseif ($schedule->status === 'completed' || 'done' === $schedule->status)
                                            {{-- check nilai --}}
                                            <td>
                                                {{-- penilaian instruktur --}}
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#score{{$schedule->id}}">
                                                    Cek Nilai
                                                </button>
                                            </td>
                                        @elseif($schedule->status === 'need rating')
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#rate" disabled>
                                                    Penilaian
                                                </button>
                                            </td>
                                        @elseif ($schedule->status === 'canceled')
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#rate" disabled>
                                                    Penilaian
                                                </button>
                                            </td>
                                        <td>
                                        @elseif ($schedule->status == 'pending')
                                        <td>
                                            <x-form action="{{ route('instructor.train')}}" method="post">
                                                {{-- hidden input --}}
                                                <input type="hidden" name="scheduleID" value="{{$schedule->id}}">
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    {{ __('Mulai Latihan')}}
                                                </button>
                                            </x-form>
                                        </td>
                                        @else
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#rate{{$schedule->id}}" disabled>
                                                    Penilaian
                                                </button>
                                            </td>

                                    @endif
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada jadwal</td>
                                </tr>
                                @endif
                            </tbody>
                          </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    @if($schedules)
    @foreach ($schedules as $schedule)
    <x-modal idModal="rate{{$schedule->id}}" title="Form Penilaian" customStyle="modal-lg">
        <x-form action="{{ route('instructor.addScore')}}" method="post">
            <div class="row">
                <div class="col" style="padding-left: 0">
                    <div class="container-fluid">
                        <p style="list-style: none; padding-left: 0;" class="text-primary">{{ __('Nama Peserta :') }} <br> {{$schedule->customer->firstName}} {{$schedule->customer->lastName}}</p>
                        <p style="list-style: none; padding-left: 0;" class="text-primary">{{ __('Nama Instruktur :') }} <br> {{$schedule->instructor->firstName}} {{$schedule->instructor->lastName}}</p>
                    </div>
                </div>
                <div class="col">
                    {{-- date --}}
                    <p class="text-primary">{{ __('Tanggal, Sesi')}}  {{$schedule->date}}, Sesi : {{$schedule->session}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label for="theoryKnowledge{{$schedule->id}}" class="text-primary">{{ __('Nilai Teori Pengetahuan')}}</label><br>
                    <input type="number" class="w-100" id="theoryKnowledge{{$schedule->id}}" name="theoryKnowledge" required><br>
                    <label for="practicalDriving{{$schedule->id}}" class="text-primary">{{ __('Nilai Practical Mengemudi')}}</label><br>
                    <input type="number" class="w-100" id="practicalDriving{{$schedule->id}}" name="practicalDriving" required><br>
                    <label for="hazardPerception{{$schedule->id}}" class="text-primary">{{ __('Nilai Kesadaran Mengemudi')}}</label><br>
                    <input type="number" class="w-100" id="hazardPerception{{$schedule->id}}" name="hazardPerception" required><br>
                </div>
                <div class="col-6">
                    <label for="trafficRulesCompliance{{$schedule->id}}" class="text-primary">{{ __('Nilai Kepatuhan Lalu Lintas')}}</label><br>
                    <input type="number" class="w-100" id="trafficRulesCompliance{{$schedule->id}}" name="trafficRulesCompliance" required><br>
                    <label for="confidenceAndAttitude{{$schedule->id}}" class="text-primary">{{ __('Nilai Percaya Diri dan Perilaku')}}</label><br>
                    <input type="number" class="w-100" id="confidenceAndAttitude{{$schedule->id}}" name="confidenceAndAttitude" required><br>
                    <label for="overallAssessment{{$schedule->id}}" class="text-primary">{{ __('Rata-rata Nilai')}}</label><br>
                    <input type="number" class="w-100" id="overallAssessment{{$schedule->id}}" name="overallAssessment" readonly><br>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="additionalComment{{$schedule->id}}" class="text-primary">{{ __('Tambahan Komentar')}}</label>
                    <textarea id="additionalComment{{$schedule->id}}" class="w-100" name="additionalComment" rows="4"></textarea>
                </div>
            </div>
            {{-- checkbox button isFinal --}}
            <input type="radio" name="isFinal" id="isFinal{{$schedule->id}}">
            <label for="isFinal{{$schedule->id}}" class="text-primary">{{ __('Nilai Akhir')}}</label><br>
            {{-- hidden input scheduleID --}}
            <input type="hidden" name="scheduleID" value="{{$schedule->id}}">
            {{-- hidden input customerID --}}
            <input type="hidden" name="customerID" value="{{$schedule->customer->id}}">
            {{-- hidden input instructorID --}}
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-primary">{{ __('Kirim')}}</button>
                </div>
            </div>
            <script>
                // Fungsi untuk menghitung rata-rata
                function hitungRataRata(modalId) {
                    // Mendapatkan elemen-elemen input berdasarkan modalId
                    var teoriPengetahuanInput = document.getElementById("theoryKnowledge" + modalId);
                    var practicalMengemudiInput = document.getElementById("practicalDriving" + modalId);
                    var kesadaranMengemudiInput = document.getElementById("hazardPerception" + modalId);
                    var kepatuhanLalinInput = document.getElementById("trafficRulesCompliance" + modalId);
                    var percayaDiridanPerilakuInput = document.getElementById("confidenceAndAttitude" + modalId);
                    var ratarataInput = document.getElementById("overallAssessment" + modalId);

                    // Mendengarkan perubahan nilai input
                    teoriPengetahuanInput.addEventListener("input", function () {
                        hitungRataRata(modalId);
                    });
                    practicalMengemudiInput.addEventListener("input", function () {
                        hitungRataRata(modalId);
                    });
                    kesadaranMengemudiInput.addEventListener("input", function () {
                        hitungRataRata(modalId);
                    });
                    kepatuhanLalinInput.addEventListener("input", function () {
                        hitungRataRata(modalId);
                    });
                    percayaDiridanPerilakuInput.addEventListener("input", function () {
                        hitungRataRata(modalId);
                    });

                    // Fungsi untuk menghitung rata-rata
                    function hitungRataRata(modalId) {
                        var teoriPengetahuan = parseFloat(teoriPengetahuanInput.value) || 0;
                        var practicalMengemudi = parseFloat(practicalMengemudiInput.value) || 0;
                        var kesadaranMengemudi = parseFloat(kesadaranMengemudiInput.value) || 0;
                        var kepatuhanLalin = parseFloat(kepatuhanLalinInput.value) || 0;
                        var percayaDiridanPerilaku = parseFloat(percayaDiridanPerilakuInput.value) || 0;

                        // Menghitung rata-rata
                        var totalNilai = teoriPengetahuan + practicalMengemudi + kesadaranMengemudi + kepatuhanLalin + percayaDiridanPerilaku;
                        var rataRata = totalNilai / 5;

                        // Menetapkan nilai rata-rata ke input ratarata
                        ratarataInput.value = rataRata.toFixed(2); // Menampilkan dua angka desimal
                    }
                }
                // Panggil fungsi hitungRataRata dengan idModal yang sesuai
                hitungRataRata("{{$schedule->id}}");
            </script>
        </x-form>
    </x-modal>
    @endforeach
    @endif


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
@endforeach

@endif

    <script>
        // Fungsi untuk menghitung rata-rata
        function hitungRataRata(modalId) {
            // Mendapatkan elemen-elemen input berdasarkan modalId
            var teoriPengetahuanInput = document.getElementById("theoryKnowledge" + modalId);
            var practicalMengemudiInput = document.getElementById("practicalDriving" + modalId);
            var kesadaranMengemudiInput = document.getElementById("hazardPerception" + modalId);
            var kepatuhanLalinInput = document.getElementById("trafficRulesCompliance" + modalId);
            var percayaDiridanPerilakuInput = document.getElementById("confidenceAndAttitude" + modalId);
            var ratarataInput = document.getElementById("overallAssessment" + modalId);

            // Mendengarkan perubahan nilai input
            teoriPengetahuanInput.addEventListener("input", function () {
                hitungRataRata(modalId);
            });
            practicalMengemudiInput.addEventListener("input", function () {
                hitungRataRata(modalId);
            });
            kesadaranMengemudiInput.addEventListener("input", function () {
                hitungRataRata(modalId);
            });
            kepatuhanLalinInput.addEventListener("input", function () {
                hitungRataRata(modalId);
            });
            percayaDiridanPerilakuInput.addEventListener("input", function () {
                hitungRataRata(modalId);
            });

            // Fungsi untuk menghitung rata-rata
            function hitungRataRata(modalId) {
                var teoriPengetahuan = parseFloat(teoriPengetahuanInput.value) || 0;
                var practicalMengemudi = parseFloat(practicalMengemudiInput.value) || 0;
                var kesadaranMengemudi = parseFloat(kesadaranMengemudiInput.value) || 0;
                var kepatuhanLalin = parseFloat(kepatuhanLalinInput.value) || 0;
                var percayaDiridanPerilaku = parseFloat(percayaDiridanPerilakuInput.value) || 0;

                // Menghitung rata-rata
                var totalNilai = teoriPengetahuan + practicalMengemudi + kesadaranMengemudi + kepatuhanLalin + percayaDiridanPerilaku;
                var rataRata = totalNilai / 5;

                // Menetapkan nilai rata-rata ke input ratarata
                ratarataInput.value = rataRata.toFixed(2); // Menampilkan dua angka desimal
            }
        }
    </script>
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
@endsection
