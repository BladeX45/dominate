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
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#rate" disabled>
                                                Penilaian
                                            </button>
                                        </td>
                                    @elseif($schedule->status === 'need rating')
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#rate" disabled>
                                                Penilaian
                                            </button>
                                        </td>
                                    @else
                                    <td>
                                        <x-form action="{{ route('instructor.train')}}" method="post">
                                            {{-- hidden input --}}
                                            <input type="hidden" name="scheduleID" value="{{$schedule->id}}">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                {{ __('Mulai Latihan')}}
                                            </button>
                                        </x-form>
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
                        <table class="table">
                            <thead>
                                <tr>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

@endsection
