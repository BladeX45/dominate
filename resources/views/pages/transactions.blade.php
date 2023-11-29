
@extends('layouts.app', ['page' => __('Transaksi'), 'pageSlug' => 'transaksi'])
@php
    $isClicked = false
@endphp
@section('content')
    <div class="row">
        <div class="col-md-12">
            {{-- error or success --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success')}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times</span>
                    </button>
                </div>
            @endif
            {{-- error --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ session('error')}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times</span>
                    </button>
                </div>
            @endif

            <div class="card bg-primary" style="min-height: 80vh;">
                <div class="card-header">
                    Daftar Transaksi
                </div>
                {{-- search input --}}
                <div class="row">
                    <div class="container-fluid">
                        <div class="col-md-4">
                            <div class="searchInput">
                                <input type="text" name="search" id="searchInput" class="form-control" placeholder="Cari Jadwal">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {{-- if transactions > 0 --}}
                    @if (count($data) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" id="th-transactionID">>Transaction ID</th>
                                <th scope="col" id="th-planName">Plan Name</th>
                                <th scope="col" id="th-planAount">Plan Amount</th>
                                <th scope="col" id="th-totalSession">Total Session</th>
                                <th scope="col" id="th-paymentMethod">Payment Method</th>
                                <th scope="col" id="th-paymentAmount">Payment Amount</th>
                                <th scope="col" id="th-paymentStatus">Payment Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $dt)
                                <tr>
                                    <td>{{ $dt->transactionID }}</td>
                                    <td>{{ $dt->plan->planName }}</td>
                                    <td>{{ $dt->planAmount }}</td>
                                    <td>{{ $dt->totalSession }}</td>
                                    <td>{{ $dt->paymentMethod }}</td>
                                    {{-- <td>{{ $dt->paymentAmount }}</td> format currency --}}
                                    <td>Rp. {{ number_format($dt->paymentAmount, 0, ',', '.') }}</td>
                                    <td>{{ $dt->paymentStatus }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary evidence-button" data-toggle="modal" data-target="#modalE{{$dt->id}}" data-user-id="{{$dt->id}}">
                                            Upload Evidence
                                        </button>
                                        <!-- Add a hidden input field to store the userId for each row -->
                                        <input type="hidden" id="user-id-input{{$dt->id}}">
                                    </td>
                                </tr>
                                <!-- Modal for this transaction -->
                            @endforeach
                        </tbody>
                    </table>
                    {{-- paginate --}}
                    <div class="d-flex justify-content-center">
                        {!! $data->links() !!}
                    </div>
                    {{-- if transactions = 0 --}}
                    @else
                        <h3 class="text-center text-white">Belum ada transaksi</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @foreach ($data as $dt)
        <x-modal title="Evidence" idModal="modalE{{$dt->id}}" customStyle="">
            <x-form-update id="{{$dt->id}}" data="Transaction" action="{{route('customer.uploadEvidence')}}" >
                <!-- Display a field with the data -->
                {{-- input hidden idTransaction --}}
                <div class="form-group">
                    <input type="text" class="hidden" value="{{$dt->id}}" name="transactionID" hidden>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary close-button" data-bs-dismiss="modal">Close</button>
                </div>
            </x-form-update>
        </x-modal>
    @endforeach


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var searchInput = document.getElementById("searchInput");
        // Dapatkan semua baris (tr) dalam tabel
        var rows = document.querySelectorAll("tbody tr");

        // Tambahkan event listener untuk input pencarian
        searchInput.addEventListener("input", function () {
            var searchText = searchInput.value.toLowerCase();

            // Iterasi melalui setiap baris dalam tabel
            rows.forEach(function (row) {
                // Dapatkan sel di dalam baris
                var cells = row.getElementsByTagName("td");
                var shouldShow = false;

                // Periksa apakah teks pencarian ada dalam setiap sel
                for (var i = 0; i < cells.length; i++) {
                    var cellText = cells[i].textContent.toLowerCase();
                    if (cellText.includes(searchText)) {
                        shouldShow = true;
                        break;
                    }
                }

                // Tampilkan atau sembunyikan baris berdasarkan hasil pencarian
                if (shouldShow) {
                    row.style.display = "table-row";
                } else {
                    row.style.display = "none";
                }
            });
        });
        // JavaScript code to handle the modal close event
        $('.close-button').on('click', function () {
            window.location.reload();
        });

        // Add an event listener for the button click using jQuery
        $(".evidence-button").click(function() {
            $isClicked = true; // Set it to true when the button is clicked

            // Get the user ID from the clicked button
            var userId = $(this).data('user-id');

            // Show the modal by manually triggering its display
            $('#evidence' + userId).modal('show');
        });
    </script>
    <script>
        // Dapatkan elemen header kolom yang memiliki ID
    var thTransactionID = document.getElementById("th-transactionID");
    var thPaymentStatus = document.getElementById("th-paymentStatus");

    // Inisialisasi variabel pengurutan
    var isTransactionIDSorted = false;
    var isPaymentStatusSorted = false;

    // Tambahkan event listener ke header kolom Transaction ID
    thTransactionID.addEventListener("click", function () {
        // Toggle arah pengurutan
        isTransactionIDSorted = !isTransactionIDSorted;

        // Panggil fungsi untuk mengurutkan tabel
        sortTable("transactionID", isTransactionIDSorted);
    });

    // Tambahkan event listener ke header kolom Payment Status
    thPaymentStatus.addEventListener("click", function () {
        // Toggle arah pengurutan
        isPaymentStatusSorted = !isPaymentStatusSorted;

        // Panggil fungsi untuk mengurutkan tabel
        sortTable("paymentStatus", isPaymentStatusSorted);
    });

   // Fungsi untuk mengurutkan tabel berdasarkan kolom tertentu
function sortTable(columnName, isAscending) {
    var tbody = document.querySelector("tbody");
    var rows = Array.from(tbody.querySelectorAll("tr"));

    // Sort rows berdasarkan isi kolom yang dipilih
    rows.sort(function (a, b) {
        var aValue = a.querySelector("td:nth-child(" + (columnNameIndex(columnName) + 1) + ")").textContent;
        var bValue = b.querySelector("td:nth-child(" + (columnNameIndex(columnName) + 1) + ")").textContent;

        // Di bawah ini, kita periksa apakah isi kolom adalah angka atau bukan.
        // Jika iya, kita gunakan perbandingan angka, jika tidak, gunakan perbandingan string.
        if (!isNaN(parseFloat(aValue)) && !isNaN(parseFloat(bValue))) {
            aValue = parseFloat(aValue);
            bValue = parseFloat(bValue);
        }

        if (isAscending) {
            return aValue > bValue ? 1 : -1;
        } else {
            return aValue < bValue ? 1 : -1;
        }
    });

    // Hapus semua baris dalam tabel
    rows.forEach(function (row) {
        tbody.removeChild(row);
    });

    // Tambahkan kembali baris yang telah diurutkan
    rows.forEach(function (row) {
        tbody.appendChild(row);
    });
}

// Fungsi untuk mendapatkan indeks kolom berdasarkan nama
function columnNameIndex(columnName) {
    var headerRow = document.querySelector("thead tr");
    var headers = Array.from(headerRow.querySelectorAll("th"));

    for (var i = 0; i < headers.length; i++) {
        if (headers[i].id === "th-" + columnName) {
            return i;
        }
    }

    return -1;
}

    </script>
@endsection

