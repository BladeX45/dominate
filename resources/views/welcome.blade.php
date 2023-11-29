@extends('layouts.app')

@section('content')
    <div class="header py-7 py-lg-8">
        <div class="container-fluid">
        {{-- Hero Section --}}
            <section class="hero" id="hero">
                <div class="container">
                    <div class="row" style="background-image: url({{ asset('assets/img/bg-hero.jpg') }}); background-size:cover; height:32rem; padding:2rem;" >
                        <div class="col-lg-6">
                            <div class="hero-images">
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        {{-- Features Section --}}
        <section class="features">
            <div class="container">
                <div class="row my-4">
                    <div class="col-md-12">
                        <div class="features-heading">
                            <h2>Mengapa Memilih Kami?</h2>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            {{-- Konten tengah --}}
                            <div class="col-lg-4">
                                {{-- Keunggulan dibandingkan bisnis lainnya --}}
                                {{-- Terjangkau --}}
                                <div class="card my-1 p-auto bg-primary" style="min-height: 350px">
                                    <div class="feature-item">
                                        <div class="card-header">
                                            <div class="feature-icon d-flex justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="5em" viewBox="0 0 512 512">
                                                    <!--! Font Awesome Free 6.4.2 oleh @fontawesome - https://fontawesome.com Lisensi - https://fontawesome.com/license (Lisensi Komersial) Hak Cipta 2023 Fonticons, Inc. -->
                                                    <style>svg{fill:#ffffff}</style>
                                                    <path d="M256 0c4.6 0 9.2 1 13.4 2.9L457.7 82.8c22 9.3 38.4 31 38.3 57.2c-.5 99.2-41.3 280.7-213.6 363.2c-16.7 8-36.1 8-52.8 0C57.3 420.7 16.5 239.2 16 140c-.1-26.2 16.3-47.9 38.3-57.2L242.7 2.9C246.8 1 251.4 0 256 0z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h3 class="lead">
                                                Keamanan Utama
                                            </h3>
                                            <p>
                                                Capai tingkat keamanan tertinggi dalam perjalanan Anda! Dalam kursus mengemudi kami, kami memprioritaskan keselamatan. Instruktur berpengalaman kami akan memandu Anda melalui setiap langkah dengan hati-hati dan memastikan Anda siap menghadapi jalan dengan percaya diri.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                {{-- Mudah --}}
                                <div class="card my-1 p-auto bg-primary" style="min-height: 350px">
                                    <div class="feature-item">
                                        <div class="card-header">
                                            <div class="feature-icon d-flex justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="5em" viewBox="0 0 512 512">
                                                    <!--! Font Awesome Free 6.4.2 oleh @fontawesome - https://fontawesome.com Lisensi - https://fontawesome.com/license (Lisensi Komersial) Hak Cipta 2023 Fonticons, Inc. -->
                                                    <style>svg{fill:#ffffff}</style>
                                                    <path d="M135.2 117.4L109.1 192H402.9l-26.1-74.6C372.3 104.6 360.2 96 346.6 96H165.4c-13.6 0-25.7 8.6-30.2 21.4zM39.6 196.8L74.8 96.3C88.3 57.8 124.6 32 165.4 32H346.6c-40.8 0-77.1 25.8 90.6 64.3l35.2 100.5c23.2 9.6 39.6 32.5 39.6 59.2V400v48c0 17.7-14.3 32-32 32H448c-17.7 0-32-14.3-32-32V400H96v48c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32V400 256c0-26.7 16.4-49.6 39.6-59.2zM128 288a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm288 32a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h3 class="lead">
                                                Pengemudi Profesional
                                            </h3>
                                            <p>
                                                Pelajari dari pengemudi ahli! Instruktur kami adalah ahli yang berkomitmen untuk mengajarkan teknik mengemudi yang aman dan efisien. Mereka akan berbagi pengalaman mengemudi mereka sehingga Anda dapat menjadi pengemudi yang terampil.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                {{-- Cepat --}}
                                <div class="card my-1 p-auto bg-primary" style="min-height: 350px">
                                    <div class="feature-item">
                                        <div class="card-header">
                                            <div class="feature-icon d-flex justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="5em" viewBox="0 0 384 512">
                                                    <!--! Font Awesome Free 6.4.2 oleh @fontawesome - https://fontawesome.com Lisensi - https://fontawesome.com/license (Lisensi Komersial) Hak Cipta 2023 Fonticons, Inc. -->
                                                    <style>svg{fill:#ffffff}</style>
                                                    <path d="M64 48c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16h80V400c0-26.5 21.5-48 48-48s48 21.5 48 48v64h80c8.8 0 16-7.2 16-16V64c0-8.8-7.2-16-16-16H64zM0 64C0 28.7 28.7 0 64 0H320c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64zm88 40c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16v48c0 8.8-7.2 16-16 16H104c-8.8 0-16-7.2-16-16V104zM232 88h48c8.8 0 16 7.2 16 16v48c0 8.8-7.2 16-16 16H232c-8.8 0-16-7.2-16-16V104c0-8.8 7.2-16 16-16zM88 232c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16v48c0 8.8-7.2 16-16 16H104c-8.8 0-16-7.2-16-16V232zM144-16h48c8.8 0 16 7.2 16 16v48c0 8.8-7.2 16-16 16H160c-8.8 0-16-7.2-16-16V16z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h3 class="lead">
                                                Mengemudi dengan Kenyamanan
                                            </h3>
                                            <p>
                                                Nikmati mengemudi yang nyaman! Dalam kursus kami, Anda akan mengemudi dengan fasilitas berkualitas tinggi. Kendaraan pelatihan kami selalu dalam kondisi prima. Belajar mengemudi belum pernah semudah ini.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Pricing Section --}}
            <section class="pricing my-4">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="pricing-heading">
                                <h2>Paket Tersedia:</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                       <div class="card">
                        <div class="card-header">
                            <h2 class="title">
                                Manual
                            </h2>
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($dataManual as $dm)
                                        @if($dm->planStatus == 1)
                                        <div class="col-md-3">
                                            <div class="card bg-primary">
                                                <div class="card-header">
                                                    <h2 class="title">
                                                        {{ $dm->planName }}
                                                    </h2>
                                                </div>
                                                <div class="card-body">

                                                    <p class="lead">
                                                        {{ $dm->planDescription }}
                                                    </p>
                                                    <p class="lead">
                                                        Rp.{{ number_format($dm->planPrice, 0, ',', '.') }}
                                                    </p>
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
                    {{-- Matic --}}
                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="title">
                                    Automatic
                                </h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($dataMatic as $da)
                                    @if ($da->planStatus == 1)
                                    <div class="col-md-3">
                                        <div class="card bg-primary">
                                            <div class="card-header">
                                                <h2 class="title">
                                                    {{ $da->planName }}
                                                </h2>
                                            </div>
                                            <div class="card-body">
                                                <p class="lead">
                                                    {{ $da->planDescription }}
                                                </p>
                                                <p class="lead">
                                                    {{-- price amount currency format--}}
                                                    Rp.{{ number_format($da->planPrice, 0, ',', '.') }}
                                                </p>
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
            </section>
            {{-- section for ratings instructor from customer to instructor --}}
            <section class="ratings">
                <div class="scroll-container">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="title">
                                Ulasan Pelanggan untuk Instruktur:
                            </h2>
                        </div>
                        <div class="card-body" >
                            <div class="scrolling-row">
                            @foreach ($ratings as $rating)
                                <div class="col-md-3 ratings">
                                    <div class="card bg-primary"style="min-height: 200px">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    {{-- avatar user instructor ternary --}}
                                                    <img src="{{ $rating->instructor->user->avatar ? asset('storage/avatar/' . $rating->instructor->user->avatar) : asset('storage/avatar/R.png') }}" alt="" class="img-fluid rounded-circle">
                                                </div>
                                                <div class="col-md-8">
                                                    <h4 class="title">
                                                        {{ $rating->instructor->user->name }}
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p class="lead">
                                                {{ $rating->rating }}/10
                                            </p>
                                            <p class="comment">
                                                {{-- comment and customer who gives comment --}}
                                                {{ $rating->comment }} - {{ $rating->customer->firstName}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <style>
        /* Add this CSS to your stylesheet */
        .scrolling-row {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
        }

        .ratings {
            flex: 0 0 calc(25% - 10px); /* Adjust the width as needed */
            margin-right: 10px;
        }
    </style>
@endsection

@push('style')

@endpush
