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
                                        <div class="table-responsive">
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
                                                    @foreach ($transactions as $transaction)
                                                        <tr>
                                                            <td>1</td>
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
                            <div class="col-md-4">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


