@extends('layouts.app', ['pageSlug' => 'admin.cashFlow'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-primary ">
                <div class="card-header">
                    <h3 class="card-title text-secondary">
                        Cash Flow
                    </h3>
                </div>
                <div class="card-body p-4">
                    <div class="container-fluid">
                        <div class="table-responsive">
                            <table class="table bg-dark p-3">
                                <thead class="thead">
                                    <tr>
                                        {{-- idtransaction Transaction/Expense --}}
                                        <th>ID Transaksi</th>
                                        <th>Tanggal</th>
                                        <th>Debit</th>
                                        <th>Kredit</th>
                                        <th>Saldo</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                                    @foreach ($cashflows as $cashflow)
                                        <tr>
                                            {{-- transaction_id / expense_id --}}
                                            @if($cashflow->transaction_id != null)
                                                <td>{{$cashflow->transaction->transactionID}}</td>
                                            @else
                                                <td>{{$cashflow->expense->transactionID}}</td>
                                            @endif
                                            <td>{{$cashflow->date}}</td>
                                            <td>{{$cashflow->debitAmount}}</td>
                                            <td>{{$cashflow->creditAmount}}</td>
                                            <td>{{$cashflow->balance}}</td>
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
@endsection
