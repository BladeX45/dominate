<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        /* style page landscape a4 */
        @page {
            size: A4 landscape;
            margin: 0;
        }

        body{
            /* border  top left bottom right*/
            margin: 0 0 0 0;
            padding: 0 0 10% 0;
            /* height full screen */
            height: 100%;
        }

        /* watermark */
        .watermark {
            position: fixed;
            width: 100%;
            height: 100%;
        }

        .container{
            /* center screen */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 15px solid rgb(255, 0, 0);
            /* padding top and bottom */
            margin: 0 0 0 0;
            padding: 3% 0 4% 0;
            height: 50vh
        }

    </style>
    <title>Sertifikat</title>
  </head>
  <body>
    <div class="watermark opacity-25">
        <img class="" src="{{ asset('storage/certificate/logo.png') }}" alt="" width="100%" height="100%">
    </div>
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center pt-4">
                Sertifikat
            </h1>
            {{-- certificateNumber --}}
            <h2 class="text-center">
                <strong>Nomor Sertifikat : {{ $certificate->certificateNumber }}</strong>
            </h2>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="title text-center">
                    Sertifikat Kelulusan Kursus Mengemudi
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center">
                    Diberikan kepada :
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center">
                    {{-- strong underline --}}
                    <strong style="text-decoration-line: underline">{{ $customer->firstName}} {{ $customer->lastName }}</strong>
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h5 class="text-center">
                    Atas Kelulusan Kursus Mengemudi di Praba Jaya pada tanggal {{$certificate->certificateDate}}
                </h5>
                <h5 class="text-center">
                    dan telah mengikuti pelatihan dan ujian dengan baik dan taat pada peraturan yang berlaku.
                </h5>
            </div>
        </div>

        {{-- check verification certificate --}}
        <div class="row">
            <div class="col-md-12">
                <h5 class="text-center">
                    Untuk memverifikasi sertifikat ini, silahkan kunjungi
                </h5>
                <h5 class="text-center">
                    <a href="#">"asdasdas"</a>
                </h5>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>
