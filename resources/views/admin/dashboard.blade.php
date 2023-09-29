@extends('layouts.app', ['pageSlug' => 'admin.dashboard'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-primary">
                <div class="card-header">
                    <div class="card-title">
                        <h2 class="title">Dashboard</h2>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="title">
                                            Transaksi
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive" style="max-height: 100vh">
                                            <table class="table">
                                                <thead class="thead">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>ID Transaksi</th>
                                                        <th>Nama Customer</th>
                                                        <th>Status Transaksi</th>
                                                    </tr>
                                                </thead>
                                                <div class="tbody">
                                                    {{-- @dd($transactions) --}}
                                                    @php
                                                        $iTransactions = 1;
                                                    @endphp
                                                    @foreach ($transactions as $transaction)
                                                        <tr>
                                                            <td>{{$iTransactions++}}</td>
                                                            <td>{{$transaction->transactionID}}</td>
                                                            <td>{{$transaction->customer->firstName}} {{$transaction->customer->lastName}}</td>
                                                            <td>{{$transaction->paymentStatus}}</td>
                                                        </tr>
                                                    @endforeach
                                                </div>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card" style="max-height:50vh: 100%; display: flex; flex-direction: column;">
                                            <div class="card-header">
                                                <h3 class="title">
                                                    Penjualan Paket
                                                </h3>
                                            </div>
                                            <div class="card-body" style="flex: 1; overflow-y: auto;">
                                                {{-- planChart --}}
                                                <canvas id="planChart" style="max-height: 100%;"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card table-responsive"  style="max-height: 57vh">
                                            <div class="card-header">
                                                <h3 class="title">
                                                    Daftar Mobil
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <table class="table">
                                                    {{-- cars --}}
                                                    <thead class="thead">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nama Mobil</th>
                                                            <th>Tipe Mobil</th>
                                                            <th>Jenis Transmisi</th>
                                                            <th>status Mobil</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tbody">
                                                        @php
                                                            $iCars = 1;
                                                        @endphp
                                                        @foreach ($cars as $car)
                                                            <tr>
                                                                <td>{{$iCars++}}</td>
                                                                <td>{{$car->carName}}</td>
                                                                <td>{{$car->carModel}}</td>
                                                                <td>{{$car->Transmission}}</td>
                                                                <td>{{$car->carStatus}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            {{-- expenses --}}
                                            <div class="card-header">
                                                <h3 class="title">
                                                    Pengeluaran
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive" style="max-height: 40vh">
                                                    <table class="table">
                                                        <thead class="thead">
                                                            <tr>
                                                                <th>No</th>
                                                                <th>ID Transaksi</th>
                                                                <th>Nama Transaksi</th>
                                                                <th>Jumlah Keluar</th>
                                                                <th>Tanggal Transaksi</th>
                                                                <th>deskripsi</th>
                                                            </tr>
                                                        </thead>
                                                        <div class="tbody">
                                                            @php
                                                                $iExpenses = 1;
                                                            @endphp
                                                            @foreach ($expenses as $expense)
                                                                <tr>
                                                                    <td>{{$iExpenses++}}</td>
                                                                    <td>{{$expense->transactionID}}</td>
                                                                    <td>{{$expense->expenseName}}</td>
                                                                    <td>{{$expense->expenseAmount}}</td>
                                                                    <td>{{$expense->expenseDate}}</td>
                                                                    <td>{{$expense->expenseDescription}}</td>
                                                                </tr>
                                                            @endforeach
                                                        </div>
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
            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // Data persentase penjualan rencana (plan)
  var percentageData = [
            @foreach($percentageData as $data)
                {
                    label: '{{$data['Plan']}}',
                    value: {{$data['Percentage']}},
                },
            @endforeach
        ];

        // Mendapatkan elemen canvas
        var canvas = document.getElementById('planChart');

        // Membuat pie chart menggunakan Chart.js
        var ctx = canvas.getContext('2d');
        var chart = new Chart(ctx, {
            type: 'pie',
            data: {
                datasets: [{
                    data: percentageData.map(function(item) {
                        return item.value;
                    }),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        // Anda dapat menambahkan lebih banyak warna sesuai jumlah rencana
                    ],
                }],
                labels: percentageData.map(function(item) {
                    return item.label;
                }),
            },
            options: {
                title: {
                    display: true,
                    text: 'Persentase Penjualan Rencana',
                },
            },
        });
</script>
@endpush


