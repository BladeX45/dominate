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
            <form method="post" action="{{ route('profile.update') }}" autocomplete="off">
                <div class="card-body">
                    @csrf
                    @method('put')

                    @include('alerts.success')

                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                        <label>{{ __('Name') }}</label>
                        <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', auth()->user()->name) }}">
                        @include('alerts.feedback', ['field' => 'name'])
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group{{ $errors->has('firstName') ? ' has-danger' : '' }}">
                                <label>{{ __('First Name') }}</label>
                                <input type="text" name="firstName" class="form-control{{ $errors->has('firstName') ? ' is-invalid' : '' }}" placeholder="{{ __('First Name') }}" value="{{ old('firstName', auth()->user()->customer->firstName) }}">
                                @include('alerts.feedback', ['field' => 'firstName'])
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group{{ $errors->has('lastName') ? ' has-danger' : '' }}">
                                <label>{{ __('Last Name') }}</label>
                                <input type="text" name="lastName" class="form-control {{ $errors->has('lastName') ? ' is-invalid' : '' }}" placeholder="{{ __('Last Name') }}" value="{{ old('lastName', auth()->user()->customer->lastName) }}">
                                @include('alerts.feedback', ['field' => 'lastName'])
                            </div>
                        </div>
                    </div>
                    {{-- Birth Date --}}
                    <div class="form-group{{ $errors->has('birthDate') ? ' has-danger' : '' }}">
                        <label>{{ __('Birth Date') }}</label>
                        <input type="date" name="birthDate" class="form-control {{ $errors->has('birthDate') ? ' is-invalid' : '' }}" value="{{ old('birthDate', auth()->user()->customer->birthDate) }}">
                        @include('alerts.feedback', ['field' => 'birthDate'])
                    </div>
                    {{-- phone --}}
                    <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                        <label>{{ __('Phone Number') }}</label>
                        <input type="text" name="phone" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('(+62) XXXX-XXXX-XXXX') }}" value="{{ old('phone', auth()->user()->customer->phone) }}">
                        @include('alerts.feedback', ['field' => 'phone '])
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-fill btn-primary">{{ __('Save') }}</button>
                </div>
            </form>
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
                                        <img class="avatar" src="{{ asset('black') }}/img/emilyz.jpg" alt="">
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
                                <button type="submit" class="btn btn-fill btn-primary">{{ __('Upload image') }}</button>
                            </div>
                        </form>

                        <h5 class="title">{{ auth()->user()->name }}</h5>
                        <p class="email">
                            {{ auth()->user()->email }}
                        </p>
                    </div>
                </p>
                <div class="card-description">
                    {{-- Token --}}
                    @php
                        $totalSession = auth()->user()->customer->ManualSession + auth()->user()->customer->MaticSession;
                    @endphp
                    <span>Token Training : {{ $totalSession}}</span><hr/>
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
</script>
@endsection
