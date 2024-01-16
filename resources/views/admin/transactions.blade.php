@extends('layouts.app', ['pageSlug' => 'admin.transactions'])

@section('content')

{{-- status --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true" class="text-white">&times;</span>
        </button>
    </div>
@endif
{{-- create table for data --}}
{{-- username, planID, planAmount, totalSession, transactionID, paymentMethod, paymentStatus, receiptTransfer, created_at --}}
<div class="card">
    <div class="card-header">
        <h3 class="title">Transactions</h3>
    </div>
    <div class="row">
        <div class="container-fluid">
            <div class="col-md-4">
                <div class="searchInput">
                    <input type="text" name="search" id="searchInput" class="form-control" placeholder="Search Transaction">
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Username</th>
                        <th scope="col">Transaction ID</th>
                        <th scope="col">Plan</th>
                        <th scope="col">Plan Amount</th>
                        <th scope="col">Payment Amount</th>
                        <th scope="col">Total Session</th>
                        <th scope="col">Payment Method</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Receipt Transfer</th>
                        <th scope="col">Transaction Date</th>
                        <th scope="col" class="d-flex justify-content-center">Action</th>
                    </tr>
                </thead>
                <tbody id="data">
                    @foreach ($data as $transaction)
                    <tr>
                        <td>{{ $transaction->userName }}</td>
                        <td>{{ $transaction->transactionID }}</td>
                        <td>{{ $transaction->planName }}</td>
                        <td>{{ $transaction->planAmount }}</td>
                        {{-- format IDR paymentAmount --}}
                        <td>{{ 'Rp. '.number_format($transaction->paymentAmount, 0, ',', '.') }}</td>
                        <td>{{ $transaction->totalSession }}</td>
                        <td>{{ $transaction->paymentMethod }}</td>
                        <td>{{ $transaction->transactionStatus }}</td>
                        {{-- if receiptTransfer != null --}}
                        @if($transaction->receiptTransfer != null)
                            <td>
                                <a href="#" data-toggle="modal" data-target="#imageModal{{$transaction->transactionID}}">
                                    <img src="{{ asset('storage/receipts/'.$transaction->receiptTransfer) }}" alt="receiptTransfer" style="height:5rem;">
                                </a>
                                {{-- Modal --}}
                                <x-modal title="Evidence" idModal="imageModal{{$transaction->transactionID}}" customStyle="">
                                    <img src="{{ asset('storage/receipts/'.$transaction->receiptTransfer) }}" alt="receiptTransfer" style="height:100%;">
                                </x-modal>
                            </td>
                        @else
                            <td class="d-flex justify-content-center">
                                <img src="https://w7.pngwing.com/pngs/29/173/png-transparent-null-pointer-symbol-computer-icons-pi-miscellaneous-angle-trademark.png" alt="null" style="height: 1.5rem;">
                            </td>
                        @endif
                        {{-- date format DD/MM/yyy --}}
                        <td>{{ date('Y/m/d', strtotime($transaction->transactionDate)) }}</td>
                        {{-- verify transaction --}}
                        <td>
                            {{-- if success disabled verify, when pending show button tolak and verify --}}
                            @if ($transaction->transactionStatus == 'success')
                                <button type="button" class="btn btn-sm btn-info evidence-button" disabled>Verify</button>
                            @else
                            <button type="button" class="btn btn-sm btn-info evidence-button" data-toggle="modal" data-target="#verify{{ $transaction->transactionID }}">Verify</button>
                            {{-- Modal --}}
                            <x-modal title="Verify" idModal="verify{{ $transaction->transactionID }}" customStyle="">
                                <h3 class="title">Are you sure to verify this transaction?</h3>
                                <form action="{{ route('admin.verifyTransaction') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="transactionID" value="{{ $transaction->transactionID }}">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-6 d-flex justify-content-center">
                                            <button type="submit" class="btn btn-primary">Verify</button>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-center">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </x-modal>
                            {{-- form tolak --}}
                            <button type="button" class="btn btn-sm btn-danger evidence-button" data-toggle="modal" data-target="#reject{{ $transaction->transactionID }}">Reject</button>
                            {{-- Modal --}}
                            <x-modal title="Reject" idModal="reject{{ $transaction->transactionID }}" customStyle="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>
                                            {{__('Are you sure to reject this transaction?')}}
                                        </h3>
                                    </div>
                                </div>
                                <form action="{{ route('admin.rejectTransaction') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="transactionID" value="{{ $transaction->transactionID }}">
                                    <div class="row">
                                        <div class="col-md-6 d-flex justify-content-center">
                                            <button type="submit" class="btn btn-danger">Reject</button>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-center">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </x-modal>
                            @endif
                        </td>
                    </tr>
                    @endforeach
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
            <p id="noDataFoundMessage" style="display: none; color: red;">Data not Found</p>
        </div>
    </div>
</div>


@endsection
