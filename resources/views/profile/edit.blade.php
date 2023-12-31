@extends('layouts.app', ['page' => __('User Profile'), 'pageSlug' => 'profile'])

@section('content')
<style>
    /* Tambahkan efek hover opacity saat kursor diarahkan ke gambar */
    .avatar-wrapper:hover img.avatar {
        opacity: 0.7;
        /* Atur nilai opacity sesuai keinginan Anda (0.0 hingga 1.0) */
    }
</style>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ __('Edit Profile') }}</h5>
            </div>
            <div class="card-body">
                {{-- if instructor --}}
                <form method="post" action="{{route('profile.update')}}" autocomplete="off">
                    <div class="card-body">
                        @csrf
                        @method('put')

                        @include('alerts.success')

                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label>{{ __('Name') }}</label>
                            <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', auth()->user()->name) ?: '' }}">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>
                        <div class="form-group{{ $errors->has('NIN') ? ' has-danger' : '' }}">
                            <label>{{ __('NIN (Nasional Identity Number)') }}</label>
                            <input type="text" name="NIN" class="form-control{{ $errors->has('NIN') ? ' is-invalid' : '' }}" placeholder="{{ __('NIN') }}" value="{{ old('NIN', (auth()->user()->instructor ? auth()->user()->instructor->NIN : (auth()->user()->customer ? auth()->user()->customer->NIN : ''))) }}">
                            @include('alerts.feedback', ['field' => 'NIN'])
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group{{ $errors->has('firstName') ? ' has-danger' : '' }}">
                                    <label>{{ __('First Name') }}</label>
                                    <input type="text" name="firstName" class="form-control{{ $errors->has('firstName') ? ' is-invalid' : '' }}" placeholder="{{ __('First Name') }}" value="{{ old('firstName', (auth()->user()->instructor ? auth()->user()->instructor->firstName : (auth()->user()->customer ? auth()->user()->customer->firstName : ''))) }}">
                                    @include('alerts.feedback', ['field' => 'firstName'])
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group{{ $errors->has('lastName') ? ' has-danger' : '' }}">
                                    <label>{{ __('Last Name') }}</label>
                                    <input type="text" name="lastName" class="form-control {{ $errors->has('lastName') ? ' is-invalid' : '' }}" placeholder="{{ __('Last Name') }}" value="{{ old('lastName', (auth()->user()->instructor ? auth()->user()->instructor->lastName : (auth()->user()->customer ? auth()->user()->customer->lastName : ''))) }}">
                                    @include('alerts.feedback', ['field' => 'lastName'])
                                </div>
                            </div>
                        </div>
                        {{-- Birth Date --}}
                        {{-- check auth instructor or not --}}
                        @if(Auth::user()->roleID == 3)
                            <div class="row">
                                <div class="col">
                                    <div class="form-group{{ $errors->has('birthDate') ? ' has-danger' : '' }}">
                                    <label for="birthDate">{{__('Birth Date')}}</label>
                                    <input type="date" name="birthDate" class="form-control {{ $errors->has('birthDate') ? ' is-invalid' : '' }}" placeholder="{{ __('Birth Date') }}" value="{{ old('birthDate', (auth()->user()->instructor ? auth()->user()->instructor->birthDate : (auth()->user()->customer ? auth()->user()->customer->birthDate : ''))) }}">
                                    </div>
                                </div>
                                {{-- drivingExperience --}}
                                <div class="col">
                                    <div class="form-group{{ $errors->has('drvingExperience') ? ' has-danger' : '' }}">
                                        <label for="drivingExperience">{{__('Driving Experience')}}</label>
                                        <input type="text" name="drivingExperience" class="form-control {{ $errors->has('drivingExperience') ? ' is-invalid' : '' }}" placeholder="{{ __('Driving Experience') }}" value="{{ old('drivingExperience', (auth()->user()->instructor ? auth()->user()->instructor->drivingExperience : (auth()->user()->customer ? auth()->user()->customer->drivingExperience : ''))) }}">
                                    </div>
                                </div>
                            </div>
                        @else
                        <div class="form-group{{ $errors->has('birthDate') ? ' has-danger' : '' }}">
                            <label for="birthDate">{{__('Birth Date')}}</label>
                            <input type="date" name="birthDate" class="form-control {{ $errors->has('birthDate') ? ' is-invalid' : '' }}" placeholder="{{ __('Birth Date') }}" value="{{ old('birthDate', (auth()->user()->instructor ? auth()->user()->instructor->birthDate : (auth()->user()->customer ? auth()->user()->customer->birthDate : ''))) }}">
                        </div>
                        @endif

                        {{-- Gender --}}
                        <fieldset class="form-group{{ $errors->has('gender') ? ' has-danger' : '' }}">
                            <div class="row">
                              <legend class="col-form-label col-sm-2 pt-0 text-light">{{__('Gender')}}</legend>
                              <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{(auth()->user()->instructor && auth()->user()->instructor->gender == 'Male') || (auth()->user()->customer && auth()->user()->customer->gender == 'Male') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="male">
                                        {{__('Male')}}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{(auth()->user()->instructor && auth()->user()->instructor->gender == 'female') || (auth()->user()->customer && auth()->user()->customer->gender == 'female') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="female">
                                        {{__('Female')}}
                                    </label>
                                </div>
                              </div>
                            </div>
                          </fieldset>

                        {{-- phone --}}
                        <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                            <label>{{ __('Phone Number') }}</label>
                            <input type="text" name="phone" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('(+62) XXXX-XXXX-XXXX') }}" value="{{ old('phone', (auth()->user()->instructor ? auth()->user()->instructor->phone : (auth()->user()->customer ? auth()->user()->customer->phone : ''))) }}" pattern="\d+" title="Please fill with Numeric">
                            @include('alerts.feedback', ['field' => 'phone'])
                        </div>

                        {{-- address --}}
                        <div class="form-group {{ $errors->has('address') ? 'has-danger' : '' }}">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', (auth()->user()->instructor ? auth()->user()->instructor->address : (auth()->user()->customer ? auth()->user()->customer->address : ''))) }}
                            </textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ __('Password') }}</h5>
            </div>
            <form method="post" action="{{ route('profile.password') }}" autocomplete="off">
                <div class="card-body">
                    @csrf
                    @method('put')

                    @include('alerts.success', ['key' => 'password_status'])

                    <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                        <label>{{ __('Current Password') }}</label>
                        <input type="password" name="old_password" class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" placeholder="{{ __('Current Password') }}" value="" required>
                        @include('alerts.feedback', ['field' => 'old_password'])
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                        <label>{{ __('New Password') }}</label>
                        <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('New Password') }}" value="" required>
                        @include('alerts.feedback', ['field' => 'password'])
                    </div>
                    <div class="form-group">
                        <label>{{ __('Confirm New Password') }}</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="{{ __('Confirm New Password') }}" value="" required>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-fill btn-primary">{{ __('Change password') }}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-user">
            <div class="card-body">
                <p class="card-text">
                    <div class="author">
                        <div class="block block-one"></div>
                        <div class="block block-two"></div>
                        <div class="block block-three"></div>
                        <div class="block block-four"></div>
                        <form method="POST" action="{{ route('profile.photo') }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <label for="photo">
                                {{-- Jika user->avatar = null, maka tampilkan avatar default --}}
                                @if (Auth::user()->avatar === null)
                                    <div class="avatar-wrapper">
                                        <img id="image-preview"  class="avatar" src="{{ asset('black') }}/img/emilyz.jpg" alt="">
                                    </div>
                                @else
                                    <div class="avatar-wrapper">
                                        <img id="image-preview" class="avatar" src="{{ asset('storage/avatar/'. auth()->user()->avatar) }}" alt="">
                                    </div>
                                @endif
                                <input type="file" id="photo" name="photo" accept="image/*" onchange="previewImage();" hidden> <!-- Menggunakan 'photo' sebagai id dan name -->
                            </label>

                            <br>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-fill btn-primary">{{ __('Upload Image') }}</button>
                            </div>
                        </form>

                        <h5 class="title">{{ auth()->user()->name }}</h5>
                        {{-- nik --}}
                        {{-- cust ?? --}}

                            {{-- if customer show Manual and Matic Session --}}
                            @if (auth()->user()->roleID == 2)
                                {{-- Manual Token && Matic Token --}}
                                <p class="text-light">
                                    {{ __('Manual Token') }} : {{ auth()->user()->customer->ManualSession }}
                                </p>
                                <p class="text-light">
                                    {{ __('Matic Token') }} : {{ auth()->user()->customer->MaticSession }}
                                </p>
                            @endif
                            {{-- if instructor --}}
                        <p class="email">
                            {{ auth()->user()->email }}
                        </p>
                    </div>
                </p>
                <div class="card-description">
                    {{-- Manual Token && Matic Token --}}
                    @if (auth()->user()->roleID === 3)
                    @elseif(auth()->user()->roleID === 2)
                    @if (auth()->user()->customer->manualSession != null && auth()->user()->customer->maticSession != null)
                    <div class="row">
                        <div class="col">
                            <h5 class="title">{{ __('Manual Token') }}</h5>
                            <p class="description">{{ auth()->user()->customer->ManualSession }}</p>
                        </div>
                        <div class="col">
                            <h5 class="title">{{ __('Matic Token') }}</h5>
                            <p class="description">{{ auth()->user()->customer->MaticSession }}</p>
                        </div>
                    </div>
                    @endif
                    @endif
                    {{-- if instructor --}}

                </div>
                <div class="card-description">
                    {{ __('Do not be scared of the truth because we need to restart the human foundation in truth And I love you like Kanye loves Kanye I love Rick Owens’ bed design but the back is...') }}
                </div>
            </div>
            <div class="card-footer">
                <div class="button-container">
                    <button class="btn btn-icon btn-round btn-facebook">
                        <i class="fab fa-facebook"></i>
                    </button>
                    <button class="btn btn-icon btn-round btn-twitter">
                        <i class="fab fa-twitter"></i>
                    </button>
                    <button class="btn btn-icon btn-round btn-google">
                        <i class="fab fa-google-plus"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="card">
            @if(auth()->user()->roleID == 3)
    {{-- if instructor --}}
        {{-- Form update certificate image --}}
        <form method="POST" action="{{ route('instructor.certifUpdate') }}" autocomplete="off" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label for="certificate" class="d-flex justify-content-center">
                {{-- Jika user->avatar = null, maka tampilkan avatar default --}}

                @if (Auth::user()->instructor->certificate === '')
                        <img id="certificate-preview"  class="certificate" src="{{asset('storage\icons\upload.png')}}" alt="" style="height: 280px; width:75%">
                @else
                        <img id="certificate-preview" class="certificate" src="{{ asset('storage/certificates/'. auth()->user()->instructor->certificate) }}" alt="">
                @endif
                <input type="file" id="certificate" name="certificate" accept="image/*" onchange="previewCertificate();" hidden> <!-- Menggunakan 'photo' sebagai id dan name -->
            </label>

            <br>
            <div class="card-footer d-flex justify-content-center" class="mx-auto">
                <button type="submit" class="btn btn-fill btn-primary ">{{ __('Upload Certificate') }}</button>
            </div>
        </form>
        @endif
        </div>
    </div>

</div>

<script>
    function previewImage() {
        var input = document.getElementById('photo'); // Menggunakan 'photo' sebagai id
        var imagePreview = document.getElementById('image-preview');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                imagePreview.src = e.target.result;
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewCertificate() {
        var input = document.getElementById('certificate'); // Menggunakan 'photo' sebagai id
        var imagePreview = document.getElementById('certificate-preview');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                imagePreview.src = e.target.result;
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
