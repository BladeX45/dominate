@extends('layouts.app', ['pageSlug' => 'admin.assets'])

@section('content')

<style>
    .input-file{
        width: 100%;
        height: 100%;
        opacity: 0;
        position: absolute;
        top: 0;
        left: 0;
        border: 1em;
        cursor: pointer

    }
</style>
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            {{-- status --}}
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            {{-- if any error --}}
            @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.
            </div>
            @endif
          <div class="card">
            <div class="card-header card-header-primary">
                <div class="row">
                    <div class="col-10 d-flex">
                        Cars Table
                    </div>
                    <div class="col">
                        <a href="{{-- route('admin.plans.create') --}}" class="btn btn-info btn-round" data-toggle="modal" data-target="#addCar">Add Car</a>
                    </div>
                </div>
                <div class="row">
                    <div class="container-fluid">
                        <div class="col-md-4">
                            <div class="searchInput">
                                <input type="text" name="search" id="searchInput" class="form-control" placeholder="Saerch Car">
                            </div>
                        </div>
                    </div>
                </div>
              <h4 class="card-title "></h4>
              <p class="card-category"> Here is a subtitle for this table</p>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                        ID
                    </th>
                    <th>
                      Car Name
                    </th>
                    <th>
                      Transmission
                    </th>
                    <th>
                      Car Year
                    </th>
                    <th>
                      Color
                    </th>
                    <th>
                      Plate Number
                    </th>
                    <th>
                      Car Status
                    </th>
                  </thead>
                  <tbody>
                    @foreach ($cars as $car)
                    <tr>
                        <td>
                            {{ $car->id }}
                        </td>
                        <td>
                            {{ $car->carName }}
                        </td>
                        <td>
                            {{ $car->Transmission }}
                        </td>
                        <td>
                            {{ $car->carYear }}
                        </td>
                        <td>
                            {{ $car->carColor }}
                        </td>
                        <td>
                            {{ $car->carPlateNumber }}
                        </td>
                        <td>
                            {{ $car->carStatus }}
                        </td>
                        <td>
                            <a href="#" rel="tooltip" class="btn btn-info btn-sm btn-round btn-icon"
                            data-toggle="modal" data-target="#car{{ $car->id }}" data-placement="top" title="Data Mobil"
                            data-carID="{{ $car->id }}">
                            <i class="tim-icons icon-single-02"></i>
                            </a>
                        </td>
                    </tr>
                    <x-modal title="Data Mobil" idModal="car{{ $car->id }}" customStyle="modal-lg">
                        {{-- show data mobil --}}
                        {{-- @dd($car) --}}
                        <form action="{{route('admin.updateCar')}}" autocomplete="off" enctype="multipart/form-data" method="post">
                        <div class="row">
                                @method('put')
                                @csrf
                                <div class="col-md-6">
                                    {{-- carName --}}
                                    <div class="form-group">
                                        <label for="carName">{{__('Nama Mobil')}}</label>
                                        <input type="carName" name="carName" class="form-control" id="carName" value="{{old('carName',$car->carName)}}" placeholder="{{ $car->carName}}">
                                    </div>
                                    <div class="form-group">
                                        {{-- carModel --}}
                                        <label for="carModel">{{__('Model Mobil')}}</label>
                                        <input type="carModel" name="carModel" class="form-control" id="carModel" value="{{old('carModel',$car->carModel)}}" placeholder="{{ $car->carModel}}">
                                    </div>
                                    <div class="form-group">
                                        {{-- Transmission --}}
                                        <label for="Transmission">{{__('Transmisi')}}</label>
                                        <input type="Transmission" name="Transmission" class="form-control" id="Transmission" value="{{old('Transmission',$car->Transmission)}}" placeholder="{{ $car->Transmission}}">
                                    </div>
                                    <div class="form-group">
                                        {{-- carYear --}}
                                        <label for="carYear">{{__('Tahun Mobil')}}</label>
                                        <input type="carYear" name="carYear" class="form-control" id="carYear" value="{{old('carYear',$car->carYear)}}" placeholder="{{ $car->carYear}}">
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- carColor --}}
                                        <label for="carColor">{{__('Warna Mobil')}}</label>
                                        <input type="carColor" class="form-control" id="carColor" value="{{old('carColor',$car->carColor)}}" placeholder="{{ $car->carColor}}">
                                    </div>
                                    <div class="form-group">
                                        {{-- plateNumber --}}
                                        <label for="plateNumber">{{__('Nomor Plat Mobil')}}</label>
                                        <input type="plateNumber" class="form-control" id="plateNumber" value="{{old('carPlateNumber',$car->carPlateNumber)}}" placeholder="{{ $car->carPlateNumber}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="carStatus">{{ __('Status Mobil') }}</label>
                                        <select class="form-control bg-dark" id="carStatus" name="carStatus">
                                            <option value="Available">Available</option>
                                            <option value="Not Available">Not Available</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="carImage" class="d-flex justify-content-center">
                                            {{-- Jika user->avatar = null, maka tampilkan avatar default --}}
                                            @if ($car->carImage === '')
                                                    <img id="car-preview"  class="carImage" src="{{ asset('storage') }}/cars/test.png" alt="" style="height: 150px; width:75%">
                                            @else
                                                    <img id="car-preview" class="carImage" src="{{ asset('storage/cars/'. $car->carImage) }}" alt="">
                                            @endif
                                            <input type="file" id="carImage" name="carImage" accept="image/*" onchange="previewCar();" hidden> <!-- Menggunakan 'photo' sebagai id dan name -->
                                        </label>
                                    </div>
                                </div>
                        </div>
                        <script>
                                function previewCar() {
                                var input = document.getElementById('carImage'); // Menggunakan 'photo' sebagai id
                                var imagePreview = document.getElementById('car-preview');

                                if (input.files && input.files[0]) {
                                    var reader = new FileReader();

                                    reader.onload = function (e) {
                                        imagePreview.src = e.target.result;
                                    };

                                    reader.readAsDataURL(input.files[0]);
                                }
                            }
                        </script>
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-center">
                                {{-- submit --}}
                                <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                            </div>
                        </div>
                    </form>
                    </x-modal>
                    {{--  --}}
                    @endforeach
                  </tbody>
                </table>
                <nav aria-label="...">
                    <ul class="pagination">
                      <!-- Tombol Previous -->
                      @if ($cars->onFirstPage())
                      <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Sebelumnya</a>
                      </li>
                      @else
                      <li class="page-item">
                        <a class="page-link" href="{{ $cars->previousPageUrl() }}" tabindex="-1">Sebelumnya</a>
                      </li>
                      @endif

                      <!-- Tombol halaman -->
                      @foreach ($cars->getUrlRange(1, $cars->lastPage()) as $page => $url)
                      <li class="page-item{{ ($cars->currentPage() == $page) ? ' active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                      </li>
                      @endforeach

                      <!-- Tombol Next -->
                      @if ($cars->hasMorePages())
                      <li class="page-item">
                        <a class="page-link" href="{{ $cars->nextPageUrl() }}">Selanjutnya</a>
                      </li>
                      @else
                      <li class="page-item disabled">
                        <a class="page-link" href="#">Selanjutnya</a>
                      </li>
                      @endif
                    </ul>
                  </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <x-modal title="Add Car" idModal="addCar" customStyle="">
    <x-form action="test" method="post">
        <div class="form-group">
            <label for="carName">Car Name</label>
            <input type="text" name="carName" id="carName" class="form-control" placeholder="Car Name">
        </div>
        {{-- Selection Transmission --}}
        <div class="form-group">
            <label for="Transmission">Transmission</label>
            <select class="form-control bg-dark" id="Transmission" name="Transmission">
                <option value="Automatic">Automatic</option>
                <option value="Manual">Manual</option>
            </select>
        </div>
        {{-- Car Year --}}
        <div class="form-group">
            <label for="carYear">Car Year</label>
            <input type="text" name="carYear" id="carYear" class="form-control" placeholder="Car Year">
        </div>
        {{-- Car Color --}}
        <div class="form-group">
            <label for="carColor">Car Color</label>
            <input type="text" name="carColor" id="carColor" class="form-control" placeholder="Car Color">
        </div>
        {{-- Car Plate Number --}}
        <div class="form-group">
            <label for="carPlateNumber">Car Plate Number</label>
            <input type="text" name="carPlateNumber" id="carPlateNumber" class="form-control" placeholder="Car Plate Number">
        </div>
        {{-- Car Status --}}
        <div class="form-group">
            <label for="carStatus">Car Status</label>
            <select class="form-control bg-dark"  id="carStatus" name="carStatus">
                <option value="Available">Available</option>
                <option value="Not Available">Not Available</option>
            </select>
        </div>
        {{-- car Image --}}
        <div class="form-group">
            <label for="carImage">Car Image</label>
            <label for="carImage"><span id="fileName">(tidak ada file yang dipilih)</span></label>
            <input type="file" name="carImage" class="input-file text-light" id="carImage" onchange="updateFileName()">
            <script>
                function updateFileName() {
                    const fileInput = document.getElementById('carImage');
                    const fileNameSpan = document.getElementById('fileName');
                    fileNameSpan.textContent = fileInput.files.length > 0 ? fileInput.files[0].name : '(tidak ada file yang dipilih)';
                }
            </script>

          </div>
        <button type="submit" class="btn btn-primary">Submit</button>

    </x-form>
</x-modal>
@endsection




@push('js')
    <script src="{{ asset('black') }}/js/plugins/chartjs.min.js"></script>
    <script>
        $(document).ready(function() {
          demo.initDashboardPageCharts();
        });
    </script>
@endpush
