<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Certificate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lobster&family=Young+Serif&display=swap" rel="stylesheet">
<style>
    body{
        /* margin 0 padding 0 */
        margin: 0;
        padding: 50px;
        height: 100vh;
        background-color: #f2f2f2;
        /* background image from disk */
        background-image: url("https://i.pinimg.com/736x/99/62/20/9962207f98c581707032e7128a49f42e.jpg");
        background-repeat: no-repeat;
        background-size: 100% 100%;
        background-position: center;
        /* center */
        display: flex;
        justify-content: center;
    }

    .content{
        /* margin 0 padding 0 */
        margin: 2%;
        padding-top: 30px;
        height: 100%;
        /* center */
        display: flex;
        justify-content: center;
    }

    #head{
        font-family: 'Lobster', serif;
        font-size: 3rem;

    }
    #sub-head{
        font-family: 'IBM Plex Serif', serif;
        font-size: 1rem;
    }
    #sub-header{
        font-family: 'IBM Plex Serif', serif;
        font-size: 1rem;
    }
    #name{
        font-family: 'DM Serif Display', serif;
        font-size: 2rem;
        /* Uppercase*/
        text-transform: uppercase;
    }

    #test{
        border-radius: 10px;
        margin-top: -45px;
    }

    #sub-content{
        font-family: 'IBM Plex Serif', serif;
        font-size: 1rem;
        text-align: center;
    }
    .column{
        width: 150px;
        text-align: center;
    }
</style>
<body>
    <div class="content">
        <div class="container">
            <div class="row pt-5">
                <div class="col-md-3 ps-5 d-flex justify-content-center">
                    <img src="{{ asset('storage') }}/icons/prabajaya.png" alt="logo" width="150" height="150">
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-center">
                        <h1 id="head">Sertifikat Penyelesaian</h1>
                    </div>
                    <div class="row">
                        <div class="d-flex justify-content-center">
                            <h2 id="sub-head"><u>Nomor Sertifikat: {{$certificate->certificateNumber}}</u></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                </div>
            </div>
            <div class="row" id="test">
                <div class="row">
                    <div class="d-flex justify-content-center ">
                        <h3 id="sub-header">Sertifikat ini diberikan kepada :</h3><br>
                    </div>
                </div>
                <div class="row">
                    <div class="d-flex justify-content-center">
                        <h1 id="name"><u>{{$certificate->customer->firstName}} {{$certificate->customer->lastName}}</u></h1>
                    </div>
                </div>
                <div class="row">
                    <div class="d-flex justify-content-center py-1">
                        <h3 id="sub-content" class="p-2">Setelah Menyelesaikan Kursus Mengemudi dari tanggal <u>{{ \Carbon\Carbon::parse($schedulesFirst->date)->format('d-F-Y') }}</u> hingga <u>{{ \Carbon\Carbon::parse($schedulesLast->date)->format('d-F-Y') }}</u>
                        </u> Yang Diselenggarakan oleh CV. Praba Jaya <br> Dengan Nilai :</h3><br>
                    </div>
                </div>
                <div class="row py-3">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 d-flex justify-content-center">
                        <table class="table-bordered">
                            <thead class="thead">
                                <tr>
                                    <th scope="col" class="column">Teori</th>
                                    <th scope="col" class="column">Praktik</th>
                                    <th scope="col" class="column">Kepercayaan Diri</th>
                                    <th scope="col" class="column">Persepsi Mengemudi</th>
                                    <th scope="col" class="column">Kepatuhan Lalin</th>
                                </tr>
                            </thead>
                            <tbody class="tbody column">
                                <tr>
                                    <td>{{$certificate->score->theoryKnowledge}}</td>
                                    <td>{{$certificate->score->practicalDriving}}</td>
                                    <td>{{$certificate->score->confidenceAndAttitude}}</td>
                                    <td>{{$certificate->score->hazardPerception}}</td>
                                    <td>{{$certificate->score->trafficRulesCompliance}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="row d-flex justify-content-center">
                        <p class="fs-6 d-flex justify-content-center">Kepala Kursus</p>
                        <p class="fs-6 d-flex justify-content-center" style="padding-top: -5px">Bogor, {{ \Carbon\Carbon::parse($certificate->certificationDate)->format('d-F-Y') }}</p>
                    </div>
                    <div class="row d-flex justify-content-center">
                        <img style="z-index: 10;width: 120px;left:43%; position: absolute;opacity:0.4 " src="{{asset('storage\icons\stample.png')}}" alt="">
                        <img src="{{asset('storage\icons\ttd.png')}}" style="width: 270px;top:30px;" alt="test">
                    </div>
                    <div class="row d-flex justify-content-center">
                        <p class="fs-6 d-flex justify-content-center">Afry Yadi</p>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
