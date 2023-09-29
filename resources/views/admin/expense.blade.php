@extends('layouts.app', ['pageSlug' => 'admin.expense'])

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
            <h3 class="title">Pengeluaran</h3>
            <button type="button" class="btn btn-sm btn-primary me-3" data-bs-toggle="modal" data-bs-target="#expense">
                <span>
                    <i class="tim-icons icon-basket-simple"><b> Tambah Transaksi</b></i>
                </span>
            </button>
        </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
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
                        @foreach ($expenses as $expense)
                        <tr>
                            <td>1</td>
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

    {{-- Modal --}}
    <x-modal idModal="expense" title="Pengeluaran" customStyle="">
        <x-form action="{{route('admin.addExpense')}}" method="post">
            {{-- expense Name --}}
            <div class="form-group">
                <label for="expenseName">Nama Pengeluaran</label>
                <input type="text" class="form-control" id="expenseName" name="expenseName" placeholder="Nama Pengeluaran" required>
            </div>
            {{-- expense Amount --}}
            <div class="form-group">
                <label for="expenseAmount">Jumlah Pengeluaran</label>
                <input type="number" class="form-control" id="expenseAmount" name="expenseAmount" placeholder="Jumlah Pengeluaran" required>
            </div>
            {{-- expense Date --}}
            <div class="form-group">
                <label for="expenseDate">Tanggal Pengeluaran</label>
                <input type="date" class="form-control" id="expenseDate" name="expenseDate" placeholder="Tanggal Pengeluaran" required>
            </div>
            {{-- expense Description --}}
            <div class="form-group">
                <label for="expenseDescription">Deskripsi Pengeluaran</label>
                <textarea class="form-control" id="expenseDescription" name="expenseDescription" rows="3" placeholder="Deskripsi Pengeluaran" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </x-form>
    </x-modal>
@endsection
