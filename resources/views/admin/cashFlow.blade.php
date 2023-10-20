@extends('layouts.app', ['pageSlug' => 'admin.cashFlow'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-secondary">
                        Cash Flow
                    </h3>
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
                            <div class="card">
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
                                    <tbody class="tbody" id="transactionTable">
                                        @foreach ($cashflows as $cashflow)
                                            <tr>
                                                {{-- transaction_id / expense_id --}}
                                                @if($cashflow->transaction_id != null)
                                                    <td>{{$cashflow->transaction->transactionID}}</td>
                                                @else
                                                    <td>{{$cashflow->expense->transactionID}}</td>
                                                @endif
                                                <td>{{$cashflow->date}}</td>
                                                <td>Rp. {{ number_format($cashflow->debitAmount, 0, ',', '.') }} IDR</td>
                                                <td>Rp. {{ number_format($cashflow->creditAmount, 0, ',', '.') }} IDR</td>
                                                <td>Rp. {{ number_format($cashflow->balance, 0, ',', '.') }} IDR</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <p id="noTransactions" style="display: none; color: red;">No Transaction This Month</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
</script>
@endsection
