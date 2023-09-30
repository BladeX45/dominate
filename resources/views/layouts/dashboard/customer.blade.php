@extends('layouts.app', ['page' => __('dashboard'), 'pageSlug' => 'dashboard'])

@section('content')
    <div class="row bg-primary">
        <div class="col-md-12">
            <div class="card bg-primary">
                <div class="card-header">
                    <h3 class="title">
                        <i class="tim-icons icon-chart-pie-36 text-primary"></i>
                        {{ __('Dashboard') }}
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="card">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-header">
                                <h3 class="title">
                                    <i class="tim-icons icon-chart-pie-36 text-primary"></i>
                                    {{ __('Overall Assessment') }}
                                </h3>
                                <canvas id="myChart">

                                </canvas>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="title">
                                        <i class="tim-icons icon-chart-pie-36 text-primary"></i>
                                        {{ __('Transaksi') }}
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table tablesorter " id="">
                                            <thead class=" text-primary">
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
                                            <tbody>
                                                @foreach($transactions as $data)
                                                    <tr>
                                                        <td>
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td>
                                                            {{ $data->user->name }}
                                                        </td>
                                                        <td>
                                                            {{ date('d/m/Y', strtotime($data->created_at)) }}
                                                        </td>
                                                        <td>
                                                            {{ $data->paymentStatus }}
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
            </div>
        </div>
    </div>
@endsection

@push('js')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    const ctx = document.getElementById('myChart');
    var scores = [
            @foreach($scores as $data)
                {
                    // label created at date format dd/mm/yyyy
                    label: "{{date('d/m/Y', strtotime($data['created_at']))}}",
                    value: {{$data['overallAssessment']}},
                },
            @endforeach
        ];

    new Chart(ctx, {
      type: 'line',
      data: {
        labels: scores.map(function(item) {
                        return item.label;
                }),
        datasets: [{
          label: 'Overall Assessment',
          data: scores.map(function(item) {
                        return item.value;
                }),
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: false
          }
        }
      }
    });
  </script>
@endpush
