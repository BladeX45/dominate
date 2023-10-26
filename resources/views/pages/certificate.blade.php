<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
      crossorigin="anonymous"
    >
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
    <style>
      /* style page landscape a4 */
      @page {
        size: A4 landscape;
        margin: 0;
      }

      body {
        /* border top left bottom right */
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

      .container {
        /* center screen */
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border: 15px solid rgb(255, 0, 0);
        /* padding top and bottom */
        margin: 0 0 0 0;
        padding: 3% 0 4% 0;
        height: 50vh;
      }
    </style>
    <title>Sertifikat</title>
  </head>
  <body id="content">
    <div class="watermark opacity-25">
      <img
        class=""
        src="{{ asset('storage/certificate/logo.png') }}"
        alt=""
        width="100%"
        height="100%"
      >
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
            <strong
              style="text-decoration: underline"
            >
              {{ $certificate->customer->firstName }} {{ $certificate->customer->lastName }}
            </strong>
          </h3>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <h5 class="text-center">
            Atas Kelulusan Kursus Mengemudi di Praba Jaya pada tanggal
            {{ $certificate->certificateDate }}
          </h5>
          <h5 class="text-center">
            dan telah mengikuti pelatihan dan ujian dengan baik dan taat pada
            peraturan yang berlaku.
          </h5>
        </div>
        <footer class="text-center">
          <button style="z-index: 2" id="generate-pdf">Generate PDF</button>
        </footer>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>
      document.getElementById('generate-pdf').addEventListener('click', function () {
        const content = document.getElementById('content').innerHTML;
        const doc = new jsPDF({
          orientation: "landscape",
          unit: "in",
          format: [4, 2]
        });

        doc.fromHTML(content, 10, 10, {}, function () {
          doc.save("two-by-four.pdf");
        });
      });
    </script>
  </body>
</html>
