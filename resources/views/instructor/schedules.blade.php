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
                                @foreach ($schedules as $schedule)
                                <tr>
                                    <td scope="row">{{$schedule->customer->firstName}} {{$schedule->customer->lastName}}</td>
                                    <td class="fs-2">{{$schedule->date}}, Sesi : {{$schedule->session}} </td>
                                    <td class="fs-2">{{$schedule->car->carName}}</td>
                                    <td class="fs-2">{{$schedule->status}}</td>
                                    {{-- if status === success then disable button --}}
                                    @if('trained' === $schedule->status)
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#rate" >
                                                Penilaian
                                            </button>
                                        </td>
                                    @elseif ($schedule->status === 'completed')
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

    <x-modal idModal="rate" title="Form Penilaian" customStyle="modal-lg">
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
                    <label for="theoryKnowledge" class="text-primary">{{ __('Nilai Teori Pengetahuan')}}</label><br>
                    <input type="number" class="w-100" id="theoryKnowledge" name="theoryKnowledge" required><br>
                    <label for="practicalDriving" class="text-primary">{{ __('Nilai Practical Mengemudi')}}</label><br>
                    <input type="number" class="w-100" id="practicalDriving" name="practicalDriving" required><br>
                    <label for="hazardPerception" class="text-primary">{{ __('Nilai Kesadaran Mengemudi')}}</label><br>
                    <input type="number" class="w-100" id="hazardPerception" name="hazardPerception" required><br>
                </div>
                <div class="col-6">
                    <label for="trafficRulesCompliance" class="text-primary">{{ __('Nilai Kepatuhan Lalu Lintas')}}</label><br>
                    <input type="number" class="w-100" id="trafficRulesCompliance" name="trafficRulesCompliance" required><br>
                    <label for="confidenceAndAttitude" class="text-primary">{{ __('Nilai Percaya Diri dan Perilaku')}}</label><br>
                    <input type="number" class="w-100" id="confidenceAndAttitude" name="confidenceAndAttitude" required><br>
                    <label for="overallAssessment" class="text-primary">{{ __('Rata-rata Nilai')}}</label><br>
                    <input type="number" class="w-100" id="overallAssessment" name="overallAssessment" readonly><br>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="additionalComment" class="text-primary">{{ __('Tambahan Komentar')}}</label>
                    <textarea id="additionalComment" class="w-100" name="additionalComment" rows="4"></textarea>
                </div>
            </div>
            {{-- checkbox button isFinal --}}
            <input type="radio" name="isFinal" id="isFinal">
            <label for="isFinal" class="text-primary">{{ __('Nilai Akhir')}}</label><br>
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
        </x-form>
    </x-modal>

    <script>
        // Mendapatkan elemen-elemen input
        var teoriPengetahuanInput = document.getElementById("theoryKnowledge");
        var practicalMengemudiInput = document.getElementById("practicalDriving");
        var kesadaranMengemudiInput = document.getElementById("hazardPerception");
        var kepatuhanLalinInput = document.getElementById("confidenceAndAttitude");
        var percayaDiridanPerilakuInput = document.getElementById("confidenceAndAttitude");
        var ratarataInput = document.getElementById("overallAssessment");

        // Mendengarkan perubahan nilai input
        teoriPengetahuanInput.addEventListener("input", hitungRataRata);
        practicalMengemudiInput.addEventListener("input", hitungRataRata);
        kesadaranMengemudiInput.addEventListener("input", hitungRataRata);
        kepatuhanLalinInput.addEventListener("input", hitungRataRata);
        percayaDiridanPerilakuInput.addEventListener("input", hitungRataRata);

        // Fungsi untuk menghitung rata-rata
        function hitungRataRata() {
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
    </script>
@endsection
