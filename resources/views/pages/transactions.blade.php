@extends('layouts.app', ['page' => __('Transaksi'), 'pageSlug' => 'transaksi'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-primary" style="min-height: 80vh;">
                <div class="card-header">
                    Daftar Transaksi
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>IDTransaksi</th>
                                <th>Nama Paket</th>
                                <th>Jumlah Paket</th>
                                <th>Total Sesi</th>
                                <th>Metode Pembayaran</th>
                                <th>Total Harga</th>
                                <th>Status Transaksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $dt)
                                <tr>
                                    <td>{{ $dt->transactionID }}</td>
                                    <td>{{ $dt->plaName }}</td>
                                    <td>{{ $dt->planAmount }}</td>
                                    <td>{{ $dt->totalSession }}</td>
                                    <td>{{ $dt->paymentMethod }}</td>
                                    <td>{{ $dt->paymentAmount }}</td>
                                    <td>{{ $dt->paymentStatus }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
