@extends('layouts.app', ['pageSlug' => 'admin.transactions'])

@section('content')

{{-- create table for data --}}
{{-- username, planID, planAmount, totalSession, transactionID, paymentMethod, paymentStatus, receiptTransfer, created_at --}}
<div class="card">
    <div class="card-header">
        <h3 class="title">Transactions</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
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
                        <th scope="col">Transaction Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $transaction)
                    <tr>
                        <td>{{ $transaction->userName }}</td>
                        <td>{{ $transaction->planID }}</td>
                        <td>{{ $transaction->planAmount }}</td>
                        <td>{{ $transaction->totalSession }}</td>
                        <td>{{ $transaction->transactionID }}</td>
                        <td>{{ $transaction->paymentMethod }}</td>
                        <td>{{ $transaction->transactionStatus }}</td>
                        {{-- if receiptTransfer != null --}}
                        @if($transaction->receiptTransfer != null)
                            <td><img src="{{ asset('storage/receipts/'.$transaction->receiptTransfer) }}" alt="receiptTransfer" style="height:5rem;"></td>
                        @else
                            <td class="text-center"><img src="https://w7.pngwing.com/pngs/29/173/png-transparent-null-pointer-symbol-computer-icons-pi-miscellaneous-angle-trademark.png" alt="null" style="height: 1.5rem;"></td>
                        @endif
                        <td>{{ $transaction->transactionDate }}</td>
                        {{-- verify transaction --}}
                        <td>
                            <form action="{{ route('admin.verifyTransaction') }}" method="POST">
                                @csrf
                                <input type="hidden" name="transactionID" value="{{ $transaction->transactionID }}">
                                @if($transaction->transactionStatus === 'success')
                                    <button type="submit" class="btn btn-primary" disabled>Verify</button>
                                @else
                                    <button type="submit" class="btn btn-primary">Verify</button>
                                @endif

                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
