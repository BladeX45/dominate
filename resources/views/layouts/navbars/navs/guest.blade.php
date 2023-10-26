<nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent fixed-top">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <div class="navbar-toggle d-inline">
                <button type="button" class="navbar-toggler">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </button>
            </div>
            <a class="navbar-brand" href="{{route('welcome')}}">{{ $page ?? 'WELCOME' }}</a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
        </button>
        <div class="collapse navbar-collapse" id="navigation">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">

                    <!-- Button to open the modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#checkCertificate">
                        <i class="tim-icons icon-minimal-left"></i> Check Certificate
                    </button>
                </li>
                <li class="nav-item ">
                    <a href="{{ route('register') }}" class="nav-link">
                        <i class="tim-icons icon-laptop"></i> {{ __('Register') }}
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="{{ route('login') }}" class="nav-link">
                        <i class="tim-icons icon-single-02"></i> {{ __('Login') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<x-modal title="Check Certificate" idModal="checkCertificate" customStyle="">
    <x-form action="{{ route('check-certificate')}}" method="post">
        {{-- certificate number --}}
        <div class="form-group">
            <label for="certificateNumber">Certificate Number</label>
            <input type="text" class="form-control" id="certificateNumber" name="certificateNumber" placeholder="Certificate Number" required>
        </div>

        {{-- submit --}}
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Check</button>
        </div>
    </x-form>
</x-modal>
