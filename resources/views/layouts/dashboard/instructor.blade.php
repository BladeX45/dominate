@extends('layouts.app', ['page' => __('dashboard'), 'pageSlug' => 'dashboard'])

@section('content')
    <div class="card bg-primary">
        <div class="card-header">
            <h2 class="title">
                Dashboard
            </h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="title">
                                {{ __('Jadwal') }}
                            </h2>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead">
                                        <tr>
                                            <th>
                                                {{ __('No') }}
                                            </th>
                                            <th>
                                                {{ __('Nama') }}
                                            </th>
                                            <th>
                                                {{ __('Tanggal') }}
                                            </th>
                                            <th>
                                                {{ __('Status') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody">
                                        @foreach ($schedules as $schedule)
                                            <tr>
                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>
                                                    {{ $schedule->customer->firstName }}
                                                </td>
                                                <td>
                                                    {{ date('d/m/Y', strtotime($schedule->created_at)) }}
                                                </td>
                                                <td>
                                                    {{ $schedule->status }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="title">
                                {{ __('Ratings') }}
                            </h2>
                        </div>
                        <div class="card-body">
                            <canvas id="rateChart" style="min-height: 40vh">
                            </canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card" >
                        <div class="card-header">
                            <h2 class="title">
                                {{ __('Scoring Customer') }}
                            </h2>
                        </div>
                        <div class="card-body" style="height: 44vh">
                            <table class="table table-responsive" style="max-height: 40vh">
                                <thead class="thead">
                                    <tr>
                                        <th>
                                            {{ __('No') }}
                                        </th>
                                        <th>
                                            {{ __('Nama') }}
                                        </th>
                                        <th>
                                            {{ __('ID Transaksi') }}
                                        <th>
                                            {{ __('Aksi') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                                    @foreach ($scores as $score)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>
                                                {{ $score->customer->firstName }}{{ $score->customer->lastName }}
                                            </td>
                                            <td>
                                                {{ $score->id }}
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#score{{$schedule->id}}">
                                                    Cek Nilai
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>


    // Get a reference to the canvas element
    var ctx = document.getElementById('rateChart').getContext('2d');

    // Your data for the line chart (example data)
    var chartData = {
        labels: @json($formattedLabels),
        datasets: [
            {
                label: 'Ratings',
                borderColor: 'rgb(75, 192, 192)',
                data: @json($ratingsData),
                fill: false // Line chart without fill
            }
        ]
    };

    // Create the line chart
    var lineChart = new Chart(ctx, {
        type: 'line', // Specify the chart type
        data: chartData,
        options: {
            responsive: true, // Make the chart responsive
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });


</script>
@endpush
