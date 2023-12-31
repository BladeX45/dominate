@extends('layouts.app', ['pageSlug' => 'admin.cashFlow'])

@section('content')
    {{-- if any error --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session('error') }}</strong>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session('success') }}</strong>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title text-secondary">
                                Cash Flow
                            </h3>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                            {{-- add button setModal --}}
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#setModal">
                               Add Balance
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="container-fluid">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="filterMonth">Month:</label>
                                <select class="form-control" id="filterMonth">
                                    <option class="bg-dark" value="">Show All Months</option>
                                    <option class="bg-dark" value="01">January</option>
                                    <option class="bg-dark" value="02">February</option>
                                    <option class="bg-dark" value="03">March</option>
                                    <option class="bg-dark" value="04">April</option>
                                    <option class="bg-dark" value="05">May</option>
                                    <option class="bg-dark" value="06">June</option>
                                    <option class="bg-dark" value="07">July</option>
                                    <option class="bg-dark" value="08">August</option>
                                    <option class="bg-dark" value="09">September</option>
                                    <option class="bg-dark" value="10">October</option>
                                    <option class="bg-dark" value="11">November</option>
                                    <option class="bg-dark" value="12">December</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="filterYear">Year:</label>
                                <select class="form-control" id="filterYear">
                                    <option class="text-light" value="">Show All Years</option>
                                    @for ($year = date("Y"); $year >= 2000; $year--)
                                        <option class="bg-dark" value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <div class="card bg-dark">
                                <table class="table bg-dark p-3">
                                    <thead class="thead">
                                        <tr>
                                            {{-- idtransaction Transaction/Expense --}}
                                            <th class="text-dark">ID Transaksi</th>
                                            <th class="text-dark">Tanggal</th>
                                            <th class="text-dark">Debit</th>
                                            <th class="text-dark">Kredit</th>
                                            <th class="text-dark">Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody text-dark" id="transactionTable" >
                                        @foreach ($cashflows as $cashflow)
                                            <tr>
                                                {{-- transaction_id / expense_id --}}
                                                @if($cashflow->transaction_id == null)
                                                    @if($cashflow->debitAmount != null)
                                                        <td class="text-dark">Added Balance</td>
                                                    @else
                                                        <td class="text-dark">{{$cashflow->expense->transactionID}}</td>
                                                    @endif
                                                @else
                                                    <td>{{$cashflow->transaction->transactionID}}</td>
                                                @endif
                                                <td class="text-dark">{{ date('Y/m/d', strtotime($cashflow->created_at)) }}</td>
                                                <td class="text-dark">Rp. {{ number_format($cashflow->debitAmount, 0, ',', '.') }}</td>
                                                <td class="text-dark">Rp. {{ number_format($cashflow->creditAmount, 0, ',', '.') }}</td>
                                                <td class="text-dark">Rp. {{ number_format($cashflow->balance, 0, ',', '.') }}</td>
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
                                <p id="noTransactions" style="display: none; color: red;">No Transaction This Month</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-modal title="Set Starting Balance" idModal="setModal" customStyle="">
        <x-form action="{{route('admin.setModal')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="startingBalance">Starting Balance</label>
                <input type="number" class="form-control text-dark" id="startingBalance" name="startingBalance" placeholder="Enter Starting Balance" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </x-form>
    </x-modal>

    <script>
        document.getElementById("filterMonth").addEventListener("change", filterTable);
        document.getElementById("filterYear").addEventListener("change", filterTable);

        function filterTable() {
            const selectedMonth = document.getElementById("filterMonth").value;
            const selectedYear = document.getElementById("filterYear").value;
            const rows = document.getElementById("transactionTable").getElementsByTagName("tr");
            let hasTransactions = false;

            for (let i = 0; i < rows.length; i++) {
                const transactionDate = rows[i].getElementsByTagName("td")[1].textContent;
                const transactionMonth = transactionDate.split("-")[1];
                const transactionYear = transactionDate.split("-")[0];

                if ((selectedMonth === "" || transactionMonth === selectedMonth) &&
                    (selectedYear === "" || transactionYear === selectedYear)) {
                    rows[i].style.display = "";
                    hasTransactions = true;
                } else {
                    rows[i].style.display = "none";
                }
            }

            if (!hasTransactions) {
                document.getElementById("noTransactions").style.display = "block";
            } else {
                document.getElementById("noTransactions").style.display = "none";
            }
        }
        // Initial table filter
        filterTable();
    </script>
@endsection
