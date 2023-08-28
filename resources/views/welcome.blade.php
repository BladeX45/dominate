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
                                <h1>Maju Lancar Company</h1>
                                <p class="lead">
                                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Deserunt aut distinctio dicta at natus labore nesciunt, nisi vero, reiciendis ipsa officiis illo delectus illum pariatur in ducimus harum dolorem possimus id eos molestiae rerum dignissimos. Est, dolor rem! Ea, doloremque.
                                </p>
                                <a href="https://www.creative-tim.com/product/black-dashboard" class="btn btn-primary btn-round">Buy Now</a>
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
                        <div class="col-lg-4">
                            <ul class="package-list">
                                <li class="heading">
                                    <h3>Basic</h3>
                                    <span>$29</span>
                                </li>
                                <li>1000 Downloads</li>
        </div>
    </div>
@endsection
