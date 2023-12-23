{{-- check route(welcome) ? footer welcome : default footer --}}
@if(Route::currentRouteName() == 'welcome')
<footer class="footer bg-primary">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <h4>Hubungi Kami</h4>
                <p>Jalan Contoh No. 123</p>
                <p>Kota Anda, Kode Pos</p>
                <p>Email: info@example.com</p>
                <p>Telepon: (123) 456-7890</p>
            </div>
            <div class="col-md-4">
                <h4>Tautan Berguna</h4>
                <ul>
                    <li><a href="#Hero">Home</a></li>
                    <li><a href="#Feature">Layanan</a></li>
                    <li><a href="#Paket">Paket</a></li>
                    <li><a href="#Review">Review</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h4>Ikuti Kami</h4>
                <ul class="social-icons">
                    <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

@else

<footer class="footer bg-primary">
    <div class="container-fluid">
        <ul class="nav">
            <li class="nav-item">
                <a href="https://creative-tim.com" target="blank" class="nav-link">
                    {{ __('Instagram') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="https://updivision.com" target="blank" class="nav-link">
                    {{ __('Facebook') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    {{-- Now Year --}}
                    {{ date('Y') }} {{ __('made with') }} <i class="tim-icons icon-heart-2"></i> {{ __('by') }}
                    {{ __('Benidictus Tri W') }}
                </a>
            </li>
        </ul>
    </div>
</footer>

@endif
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const navLinks = document.querySelectorAll('ul a');

    navLinks.forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            // Ambil id target dari tautan
            const targetId = this.getAttribute('href').substring(1);

            // Gulir halaman ke elemen target
            const targetElement = document.getElementById(targetId);
            targetElement.scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
});

    </script>
@endpush
