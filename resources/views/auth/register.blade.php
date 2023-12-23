@extends('layouts.app', ['class' => 'register-page', 'page' => __('Register Page'), 'contentClass' => 'register-page'])

@section('content')
<style>
    .hidden {
        display: none;
    }
</style>
    @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Whoops!</strong> There were some problems with your input.
                <ul>
                    {{-- loop all error --}}
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

                {{-- close button --}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    {{-- close icon --}}
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    <div class="row">
        {{-- alert error --}}

        <div class="col-md-5 ml-auto">
            <div class="info-area info-horizontal mt-5">
                <div class="icon icon-warning">
                    <i class="tim-icons icon-wifi"></i>
                </div>
                <div class="description">
                    <h3 class="info-title">{{ __('Driving School Services') }}</h3>
                    <p class="description text-dark">
                        {{ __('We provide comprehensive driving school services. It has been an exciting and educational journey.') }}
                    </p>
                </div>
            </div>
            <div class="info-area info-horizontal">
                <div class="icon icon-primary">
                    <i class="tim-icons icon-triangle-right-17"></i>
                </div>
                <div class="description">
                    <h3 class="info-title">{{ __('Modern Curriculum') }}</h3>
                    <p class="description text-dark">
                        {{ __('Our curriculum is designed with a modern approach to driver education, ensuring an interactive and engaging learning experience.') }}
                    </p>
                </div>
            </div>
            <div class="info-area info-horizontal">
                <div class="icon icon-info">
                    <i class="tim-icons icon-trophy"></i>
                </div>
                <div class="description">
                    <h3 class="info-title">{{ __('Satisfied Student Community') }}</h3>
                    <p class="description text-dark">
                        {{ __('We take pride in our satisfied student community. Additionally, we offer a fully customizable experience for our students.') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-7 mr-auto">
            <div class="card card-register card-white">
                <div class="card-header">
                    <img class="card-img" src="{{ asset('black') }}/img/card-primary.png" alt="Card image">
                    <h4 class="card-title">{{ __('Register') }}</h4>
                </div>
                <div class="card-body">
                    {{-- create form --}}
                    <form action="{{ route('register')}}" id="form" method="post">
                        @csrf
                        <!-- Step 1: Name, Email, Password -->
                        <div class="step" data-step="1">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Username</label>
                                        <input type="text" class="form-control w-100" id="name" name="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control w-100" id="email" name="email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control w-100" id="password" name="password">
                                    </div>
                                    <div class="form-group">
                                        <label for="password_confirmation">Password Confirmation</label>
                                        <input type="password" class="form-control w-100" id="password_confirmation" onkeydown="return event.key != 'Enter';" name="password_confirmation">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button  type="button" class="next-step btn">Next</button>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Additional Customer Information -->
                        <div class="step" data-step="2" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    {{-- firstName --}}
                                    <div class="form-group">
                                        <label for="firstName">First Name</label>
                                        <input type="text" class="form-control w-100" id="firstName" name="firstName">
                                    </div>
                                    {{-- NIN --}}
                                    <div class="form-group">
                                        <label for="NIN">NIK</label>
                                        <input type="text" class="form-control w-100" id="NIN" name="NIN">
                                    </div>
                                    <div class="form-group">
                                        <label for="birthDate">Date of Birth</label>
                                        <input type="date" class="form-control w-100" id="birthDate" name="birthDate" max="<?php echo date('Y-m-d', strtotime('-17 years')); ?>">
                                    </div>
                                    {{-- phone --}}
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" class="form-control w-100" id="phone" name="phone">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    {{-- lastName --}}
                                    <div class="form-group">
                                        <label for="lastName">Last Name</label>
                                        <input type="text" class="form-control w-100" id="lastName" name="lastName">
                                    </div>
                                    {{-- gender --}}
                                    <div class="form-group">
                                        <label for="gender">Gender</label>
                                        <select class="form-control w-100" id="gender" name="gender">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea class="form-control w-100" rows="4" id="address" name="address"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                {{-- previous and submit --}}
                                <div class="col-md-6">
                                    <button type="button" class="prev-step btn">{{__('Previous')}}</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="next-step btn">{{__('Register')}}</button>
                                </div>
                            </div>
                        </div>



                        <!-- Navigation buttons -->
                        <div class="form-navigation">
                            {{-- <button class="btn" type="button" id="prevBtn" onclick="prevStep()">Previous</button>
                            <button class="btn" type="button" id="nextBtn" onclick="nextStep()">Next</button> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
<script>
$(document).ready(function () {
    var currentStep = 1;
    var totalSteps = $('.step').length;

    // Function to show the current step
    function showStep(step) {
        $('.step').hide();
        $('.step[data-step="' + step + '"]').show();
    }

    // Function to handle "Next" button click
    $('.next-step').on('click', function () {
        if (currentStep < totalSteps) {
            currentStep++;
            showStep(currentStep);
        }
    });

    // Function to handle "Previous" button click
    $('.prev-step').on('click', function () {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });

    // Handle form submission when the third step is completed
    $('#multi-step-form').on('submit', function (e) {
        e.preventDefault();

        if (currentStep === totalSteps) {
            // Form is on the last step, submit the data
            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: '{{route('register')}}', // Replace with your server endpoint
                data: formData,


                success: function (response) {
                    // Handle success response here
                    alert('Form submitted successfully!');
                },
                error: function (error) {
                    // Handle error response here
                    alert('Form submission failed. Error: ' + JSON.stringify(error));
                }
            });
        }
    });

    // Initially show the first step
    showStep(currentStep);
});
</script>
@endpush




