@extends('layouts.app', ['page' => __('pricing'), 'pageSlug' => 'pricing'])

@section('content')
<div class="row" style="max-height: 100vh">
    <div class="col-md-12" style="">
        <div class="card">
            <div class="card-header">
                {{-- title and button cart --}}
                <div class="d-flex justify-content-between">
                    <h3 class="title">Pricing</h3>
                    <button type="button" class="btn btn-sm btn-primary me-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <span>
                            <i class="tim-icons icon-basket-simple"><b> Order</b></i>
                        </span>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row p-4">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="card bg-dark">
                                <div class="card-header">
                                    <h4 class="transmissionType">Manual</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row p-4">
                                        <div class="col-md-12">
                                            <div class="row">
                                                @foreach ($dataManual as $dt)
                                                    @if ($dt->planType == 'manual')
                                                        <div class="col-md-3 mb-4">
                                                            <div class="card bg-info">
                                                                <div class="card-header">
                                                                    <h5 class="planName">
                                                                        {{ $dt->planName }}
                                                                    </h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="planPrice">
                                                                        {{-- IDR format --}}
                                                                        {{ 'Rp. '.number_format($dt->planPrice, 0, ',', '.') }}
                                                                    </h5>
                                                                    <h5 class="planSession">
                                                                        {{ $dt->planSession }} Session
                                                                    </h5>
                                                                    <h5 class="planDescription">
                                                                        {{ $dt->planDescription }}
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="card bg-dark">
                                <div class="card-header">
                                    <h4 class="transmissionType">Matic</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row p-4">
                                        <div class="col-md-12">
                                            <div class="row">
                                                @foreach ($dataMatic as $dm)
                                                    <div class="col-md-3 mb-4">
                                                        <div class="card bg-info">
                                                            <div class="card-header">
                                                                <h5 class="planName">
                                                                    {{ $dm->planName }}
                                                                </h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <h5 class="planPrice">
                                                                    {{-- IDR format --}}
                                                                    {{ 'Rp. '.number_format($dm->planPrice, 0, ',', '.') }}
                                                                </h5>
                                                                <h5 class="planSession">
                                                                    {{ $dm->planSession }} Session
                                                                </h5>
                                                                <h5 class="planDescription">
                                                                    {{ $dm->planDescription }}
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-white">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-light" id="exampleModalLabel">Order Forms</h1>
            </div>
            <div class="modal-body">
                <x-form class="bg-white" action="{{ route('customer-order') }}" method="POST">
                    @csrf
                    {{-- transmission Type --}}
                    <div class="form-group">
                        <label for="transmissionType">Transmission Type</label>
                        <select class="form-control text-dark" id="transmissionType" name="transmissionType">
                            <option value="manual">Manual</option>
                            <option value="automatic">Matic</option>
                        </select>
                    </div>
                    {{-- selection plan --}}
                    <div class="form-group">
                        <label for="plan">Select Plan</label>
                        <select class="form-control text-dark" id="plan" name="plan" onchange="calculateTotalAmount()">
                            <option value="Basic">Basic</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advance">Advance</option>
                            <option value="1 Session">1 Session</option>
                            <option value="Paket Hemat">Paket Hemat</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="paymentMethod">Select Payment</label>
                        <select class="form-control text-dark" id="paymentMethod" name="paymentMethod">
                            <option value="transfer">Transfer</option>
                            <option value="cash">Cash</option>
                        </select>
                    </div>
                    {{-- Amount --}}
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" class="form-control bg-white text-dark" id="amount" name="amount" placeholder="Amount" onchange="calculateTotalAmount()">
                    </div>
                    {{-- total amount readonly --}}
                    <div class="form-group">
                        <label for="totalAmount">Total Price</label>
                        <input type="number" class="form-control bg-white" id="totalPrice" name="totalPrice" placeholder="Total Amount" readonly>
                    </div>
                    <div class="form-group">
                        <label for="totalSession">Total Session</label>
                        <input type="number" class="form-control bg-white" id="totalSession" name="totalSession" placeholder="Total Session" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
</div>

<script>
    var plans = {!! json_encode($data) !!}; // Mengambil data rencana dari variabel PHP

    function calculateTotalAmount() {
        // Ambil nilai dari elemen-elemen yang dibutuhkan
        var selectedPlan = document.getElementById("plan").value;
        var amount = parseFloat(document.getElementById("amount").value);


        let totalPrice = 0;
        let totalSession = 0;

        // Cari harga plan berdasarkan plan yang dipilih
        var planPrice = 0;
        for (var i = 0; i < plans.length; i++) {
            if (plans[i].planName === selectedPlan) {
                planPrice = plans[i].planPrice;
                totalPrice = planPrice * amount;
                totalSession = plans[i].planSession * amount;
                break;
            }
        }

        // Tampilkan hasil perhitungan pada elemen totalAmount dan totalSession
        document.getElementById("totalPrice").value = totalPrice;
        document.getElementById("totalSession").value = totalSession;
    }
</script>


@endsection
