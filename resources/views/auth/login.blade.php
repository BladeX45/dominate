@extends('layouts.app', ['class' => 'login-page', 'page' => __('Login Page'), 'contentClass' => 'login-page'])

@section('content')
    <div class="col-md-10 text-center ml-auto mr-auto">
        <h3 class="mb-5 text-dark">Get ready to kickstart your journey to safe and skilled driving. Explore our courses, skilled instructors, and modern fleet, all designed to make you a confident driver.</h3>
    </div>
    @if(session('error'))
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10">
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="col-lg-4 col-md-6 ml-auto mr-auto ">
        <form class="form" method="post" action="{{ route('login') }}">
            @csrf
            <div class="card card-login bg-white">
                <div class="card-header">
                    <img src="{{ asset('black') }}/img/card-primary.png" alt="">
                    <h1 class="card-title">{{ __('Log in') }}</h1>
                </div>
                <div class="card-body">
                    <div class="input-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-email-85"></i>
                            </div>
                        </div>
                        <input type="email" name="email" class="text-dark form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}">
                        @include('alerts.feedback', ['field' => 'email'])
                    </div>
                    <div class="input-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-lock-circle"></i>
                            </div>
                        </div>
                        <input type="password" placeholder="{{ __('Password') }}" name="password" class="text-dark form-control{{ $errors->has('password') ? ' is-invalid' : '' }}">
                        @include('alerts.feedback', ['field' => 'password'])
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" href="" class="btn btn-primary btn-lg btn-block mb-3">{{ __('Get Started') }}</button>
                    <div class="pull-left">
                        <h6>
                            <a href="{{ route('register') }}" class="link footer-link">{{ __('Create Account') }}</a>
                        </h6>
                    </div>
                    <div class="pull-right">
                        <h6>
                            <a href="{{ route('password.request') }}" class="link footer-link">{{ __('Forgot password?') }}</a>
                        </h6>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
