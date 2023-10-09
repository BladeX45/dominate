
@extends('layouts.app', ['page' => __('Transaksi'), 'pageSlug' => 'transaksi'])
@php
    $isClicked = false
@endphp
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
                                <th scope="col">Transaction ID</th>
                                <th scope="col">Plan Name</th>
                                <th scope="col">Plan Amount</th>
                                <th scope="col">Total Session</th>
                                <th scope="col">Payment Method</th>
                                <th scope="col">Payment Amount</th>
                                <th scope="col">Payment Status</th>
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
                                    <td>{{ $dt->paymentStatus }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary evidence-button" data-toggle="modal" data-target="#evidence{{$dt->id}}" data-user-id="{{$dt->id}}">
                                            Upload Bukti Pembayaran
                                        </button>
                                        <!-- Add a hidden input field to store the userId for each row -->
                                        <input type="hidden" id="user-id-input{{$dt->id}}">
                                    </td>
                                </tr>
                                <!-- Modal for this transaction -->
                                <x-modal title="Bukti Pembayaran" idModal="evidence{{$dt->id}}" customStyle="">
                                    <x-form-update id="{{$dt->id}}" data="Transaction" action="{{route('customer.uploadEvidence')}}">
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
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
@endsection

