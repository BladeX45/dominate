@extends('layouts.app', ['pageSlug' => 'admin.cashFlow'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-primary">
                <div class="card-header">
                    <h3 class="card-title text-secondary">
                        Cash Flow
                    </h3>
                </div>
                <div class="card-body p-4">
                    <div class="container-fluid">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="filterMonth">Bulan:</label>
                                <select class="form-control" id="filterMonth">
                                    <option value="">Tampilkan Semua Bulan</option>
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="filterYear">Tahun:</label>
                                <select class="form-control" id="filterYear">
                                    <option value="">Tampilkan Semua Tahun</option>
                                    @for ($year = date("Y"); $year >= 2000; $year--)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
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
                                            <td>{{$cashflow->debitAmount}}</td>
                                            <td>{{$cashflow->creditAmount}}</td>
                                            <td>{{$cashflow->balance}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <p id="noTransactions" style="display: none; color: red;">Tidak ada transaksi di bulan ini.</p>
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
