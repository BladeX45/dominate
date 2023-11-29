@extends('layouts.app', ['page' => __('Schedules'), 'pageSlug' => 'instructor.schedules'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="card">
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
                            <tbody id="data">
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
                                                    Score
                                                </button>
                                            </td>
                                        @elseif ($schedule->status === 'completed' || 'done' === $schedule->status)
                                            {{-- check nilai --}}
                                            <td>
                                                {{-- penilaian instruktur --}}
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#rating{{$schedule->id}}">
                                                    Check Rating
                                                </button>
                                            </td>
                                        @elseif($schedule->status === 'need rating')
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#rate" disabled>
                                                    Score
                                                </button>
                                            </td>
                                        @elseif ($schedule->status === 'canceled')
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#rate" disabled>
                                                    Score
                                                </button>
                                            </td>
                                        <td>
                                        @elseif ($schedule->status == 'pending')
                                        <td>

                                            {{-- button modal confirmation --}}
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#Confirmation{{$schedule->id}}">
                                                {{ __('Start Training')}}
                                            </button>
                                            <x-modal title="" idModal="Confirmation{{$schedule->id}}" customStyle="">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <h3 class="text-light d-flex justify-content-center">
                                                                    Are you sure want to start training?
                                                                </h3>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 d-flex justify-content-center">
                                                                <form action="{{route('instructor.train')}}" method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="scheduleID" value="{{$schedule->id}}">
                                                                    <button type="submit" class="btn btn-primary">Yes</button>
                                                                </form>
                                                            </div>
                                                            <div class="col-md-6 d-flex justify-content-center">
                                                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </x-modal>
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

    @foreach ($ratings as $rating)
    <x-modal title="Rate From Customer" idModal="rating{{$rating->scheduleID}}" customStyle="">
        {{-- Ratings Meter --}}
        <div class="row">
            <div class="col-md-12">
                {{-- scale rating->rating to /100 --}}
                @php
                    // temp rating
                    $temp_rating = $rating->rating;
                    $rating->rating = $rating->rating * 10;
                @endphp
                {{-- rating meter --}}
                {{-- if ratings => 70 --}}
                @if ($rating->rating >= 70)
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success text-dark" role="progressbar" aria-valuenow="{{$rating->rating}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$rating->rating}}%;">{{$temp_rating}}/10</div>
                    </div>
                {{-- if ratings 40 > x < 70 --}}
                @elseif ($rating->rating < 70 && $rating->rating >= 40)
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-waring text-dark" role="progressbar" aria-valuenow="{{$rating->rating}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$rating->rating}}%">{{$temp_rating}}/10</div>
                    </div>
                {{-- if ratings < 40 --}}
                @else
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger text-dark" role="progressbar" aria-valuenow="{{$rating->rating}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$rating->rating}}%">{{$temp_rating}}/10</div>
                    </div>
                @endif

                {{-- comment box --}}
                <div class="form-group pt-2">
                    <label for="exampleFormControlTextarea1">Comment :</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" readonly>{{$rating->comment}}</textarea>
                  </div>
            </div>
        </div>
    </x-modal>
    @endforeach

    @foreach ($scores as $score )
    <x-modal idModal="score{{$score->scheduleID}}" title="Participant Score" customStyle="">
        {{--  --}}
        <div class="row">
            <div class="col-md-12">
                {{-- customer name --}}
                <p class="text-primary">Participant Name: {{$score->customer->firstName}} {{$score->customer->lastName}}</p>
                {{-- instructor name --}}
                <p class="text-primary">Instructor Name: {{$score->instructor->firstName}} {{$score->instructor->lastName}}</p>
                {{-- training date --}}
                <p class="text-primary">Training Date: {{$score->schedule->date}}, Session: {{$score->schedule->session}}</p>
                {{-- scores: theoryKnowledge, practicalDriving, hazardPerception, trafficRulesCompliance, confidenceAndAttitude, overallAssessment --}}
                <p class="text-primary">Scores: </p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="theoryKnowledge" class="text-primary">{{ __('Theory Knowledge Score')}}</label><br>
                            <input type="number" class="w-100" id="theoryKnowledge" name="theoryKnowledge" value="{{$score->theoryKnowledge}}" readonly><br>
                        </div>
                        <div class="form-group">
                            <label for="practicalDriving" class="text-primary">{{ __('Practical Driving Score')}}</label><br>
                            <input type a="number" class="w-100" id="practicalDriving" name="practicalDriving" value="{{$score->practicalDriving}}" readonly><br>
                        </div>
                        <div class="form-group">
                            <label for="hazardPerception" class="text-primary">{{ __('Hazard Perception Score')}}</label><br>
                            <input type="number" class="w-100" id="hazardPerception" name="hazardPerception" value="{{$score->hazardPerception}}" readonly><br>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="trafficRulesCompliance" class="text-primary">{{ __('Traffic Rules Compliance Score')}}</label><br>
                            <input type="number" class="w-100" id="trafficRulesCompliance" name="trafficRulesCompliance" value="{{$score->trafficRulesCompliance}}" readonly><br>
                        </div>
                        <div class="form-group">
                            <label for="confidenceAndAttitude" class="text-primary">{{ __('Confidence and Attitude Score')}}</label><br>
                            <input type="number" class="w-100" id="confidenceAndAttitude" name="confidenceAndAttitude" value="{{$score->confidenceAndAttitude}}" readonly><br>
                        </div>
                        <div class="form-group">
                            <label for="overallAssessment" class="text-primary">{{ __('Overall Score')}}</label><br>
                            <input type="number" class="w-100" id="overallAssessment" name="overallAssessment" value="{{$score->overallAssessment}}" readonly><br>
                        </div>
                    </div>
                </div>
                {{-- additional comment --}}
                <p class="text-primary">Comment: {{$score->additionalComment}}</p>
                {{-- if isFinal -> 1 && overallAssessment >= 70 then show generate certificate  --}}
                @if ($score->isFinal === 1 && $score->overallAssessment >= 70)
                    {{-- certificate generation button form --}}
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
                        {{-- generate certificate button --}}
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
        <x-form action="{{ route('instructor.addScore') }}" method="post">
            <!-- Your HTML structure for participant and instructor information -->
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="theoryKnowledge{{$schedule->id}}" class="text-primary">{{ __('Theory Knowledge Score')}}</label><br>
                        <input type="number" class="w-100" id="theoryKnowledge{{$schedule->id}}" min="0" max="100" name="theoryKnowledge"  required oninput="hitungRataRata({{ $schedule->id }})"><br>
                    </div>
                    <div class="form-group">
                        <label for="practicalDriving{{$schedule->id}}" class="text-primary">{{ __('Practical Driving Score')}}</label><br>
                        <input type="number" class="w-100" id="practicalDriving{{$schedule->id}}"min="0" max="100" name="practicalDriving" required oninput="hitungRataRata({{ $schedule->id }})"><br>
                    </div>
                    <div class="form-group">
                        <label for="hazardPerception{{$schedule->id}}" class="text-primary">{{ __('Hazard Perception Score')}}</label><br>
                        <input type="number" class="w-100" id="hazardPerception{{$schedule->id}}"min="0" max="100" name="hazardPerception" required oninput="hitungRataRata({{ $schedule->id }})"><br>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="trafficRulesCompliance{{$schedule->id}}" class="text-primary">{{ __('Traffic Rules Compliance Score')}}</label><br>
                        <input type="number" class="w-100" id="trafficRulesCompliance{{$schedule->id}}"min="0" max="100" name="trafficRulesCompliance" required oninput="hitungRataRata({{ $schedule->id }})"><br>
                    </div>
                    <div class="form-group">
                        <label for="confidenceAndAttitude{{$schedule->id}}" class="text-primary">{{ __('Confidence and Attitude Score')}}</label><br>
                        <input type="number" class="w-100" id="confidenceAndAttitude{{$schedule->id}}"min="0" max="100" name="confidenceAndAttitude" required oninput="hitungRataRata({{ $schedule->id }})"><br>
                    </div>
                    <div class="form-group">
                        <label for="overallAssessment{{$schedule->id}}" class="text-primary">{{ __('Overall Score')}}</label><br>
                        <input type="number" class="w-100" id="overallAssessment{{$schedule->id}}" name="overallAssessment" readonly oninput="hitungRataRata({{ $schedule->id }})"><br>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="additionalComment{{$schedule->id}}" class="text-primary">{{ __('Additional Comment') }}</label>
                    <textarea id="additionalComment{{$schedule->id}}" class="w-100" name="additionalComment" rows="4" required></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <input type="radio" name="isFinal" id="isFinal" value="1">
                    <label for="isFinal" class="text-primary">{{ __('Certificate') }}</label><br>
                </div>
            </div>
            <input type="hidden" name="scheduleID" value="{{$schedule->id}}">
            <input type="hidden" name="customerID" value="{{$schedule->customer->id}}">
            <input type="hidden" name="instructorID" value="{{$schedule->instructor->id}}">
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-primary">{{ __('Kirim') }}</button>
                </div>
            </div>
        </x-form>
    </x-modal>
    <script>
        // Function for calculating average
        function hitungRataRata(scheduleId) {
            // Get input elements by scheduleId

            console.log(scheduleId);
            var teoriPengetahuanInput = document.getElementById("theoryKnowledge" + scheduleId);
            var practicalMengemudiInput = document.getElementById("practicalDriving" + scheduleId);
            var kesadaranMengemudiInput = document.getElementById("hazardPerception" + scheduleId);
            var kepatuhanLalinInput = document.getElementById("trafficRulesCompliance" + scheduleId);
            var percayaDiriInput = document.getElementById("confidenceAndAttitude" + scheduleId);
            var ratarataInput = document.getElementById("overallAssessment" + scheduleId);
            console.log(ratarataInput);

            // Validate input values (ensure they are numbers)
            var teoriPengetahuan = parseFloat(teoriPengetahuanInput.value) || 0;
            var practicalMengemudi = parseFloat(practicalMengemudiInput.value) || 0;
            var kesadaranMengemudi = parseFloat(kesadaranMengemudiInput.value) || 0;
            var kepatuhanLalin = parseFloat(kepatuhanLalinInput.value) || 0;
            var percayaDiri = parseFloat(percayaDiriInput.value) || 0;

            // Calculate average
            var totalNilai = teoriPengetahuan + practicalMengemudi + kesadaranMengemudi + kepatuhanLalin + percayaDiri;
            var rataRata = totalNilai / 5;

            // Set average value to the overall assessment input
            ratarataInput.value = rataRata.toFixed(2); // Show two decimal places
        }

        // Call the function when the page loads for each schedule
        hitungRataRata({{ $schedule->id }});
    </script>
    @endforeach
@endif


@endsection
