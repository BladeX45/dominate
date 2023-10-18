@extends('layouts.app')

@section('content')
    <div class="header py-7 py-lg-8">
        <div class="container-fluid">
        {{-- Hero Section --}}
            <section class="hero">
                <div class="container">
                    <div class="row" style="background-image: url({{ asset('assets/img/bg-hero.jpg') }}); background-size:cover; height:32rem; padding:2rem;" >
                        <div class="col-lg-6">
                            <div class="hero-content" >
                                <h1>CV. Praba Jaya</h1>
                            </div>
                        </div>
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
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="features-item">
                                <img src="https://s3.amazonaws.com/creativetim_bucket/products/90/original/opt_bd_thumbnail.jpg?1518665540" class="img-fluid" alt="">
                                <h3>Beautiful Interface</h3>
                                <p class="lead">
                                    Black Dashboard is a beautiful Bootstrap 4 Admin Dashboard with a huge number of components built to fit together and look amazing.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="features-item">
                                <img src="https://s3.amazonaws.com/creativetim_bucket/products/90/original/opt_bd_thumbnail.jpg?1518665540" class="img-fluid" alt="">
                                <h3>Awesome Support</h3>
                                <p class="lead">
                                    Black Dashboard is a beautiful Bootstrap 4 Admin Dashboard with a huge number of components built to fit together and look amazing.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="features-item">
                                <img src="https://s3.amazonaws.com/creativetim_bucket/products/90/original/opt_bd_thumbnail.jpg?1518665540" class="img-fluid" alt="">
                                <h3>1000+ Components</h3>
                                <p class="lead">
                                    Black Dashboard is a beautiful Bootstrap 4 Admin Dashboard with a huge number of components built to fit together and look amazing.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        {{-- Pricing Section --}}
            <section class="pricing">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="pricing-heading">
                                <h2>Choose Your Plan</h2>
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
                                            </div>
                                        </div>
                                    </div>
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
                                            </div>
                                        </div>
                                    </div>
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
                                Instructor Review
                            </h2>
                        </div>
                        <div class="card-body">
                            <div class="scrolling-row">
                            @foreach ($ratings as $rating)
                                <div class="col-md-3 ratings">
                                    <div class="card bg-primary">
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
                                                {{ $rating->comment }}
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
