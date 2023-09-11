@extends('layouts.app', ['pageSlug' => 'admin.transactions'])

@section('content')

{{-- create table for data --}}
{{-- username, planID, planAmount, totalSession, transactionID, paymentMethod, paymentStatus, receiptTransfer, created_at --}}
<table class="table">
    <thead>
        <tr>
            <th scope="col">Username</th>
            <th scope="col">Plan ID</th>
            <th scope="col">Plan Amount</th>
            <th scope="col">Total Session</th>
            <th scope="col">Transaction ID</th>
            <th scope="col">Payment Method</th>
            <th scope="col">Payment Status</th>
            <th scope="col">Receipt/Transfer</th>
            <th scope="col">Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $transaction)
        <tr>
            <td>{{ $transaction->userName }}</td>
            <td>{{ $transaction->planID }}</td>
            {{-- <td>{{ $transaction->planAmount }}</td> --}}
            {{-- <td>{{ $transaction->totalSession }}</td> --}}
            <td>{{ $transaction->transactionID }}</td>
            {{-- <td>{{ $transaction->paymentMethod }}</td> --}}
            <td>{{ $transaction->transactionStatus }}</td>
            {{-- <td>{{ $transaction->receiptTransfer }}</td> --}}
            <td>{{ $transaction->transactionDate }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
