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
{{-- if anyError --}}
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error )
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
{{-- if anyError --}}
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
              <h4 class="card-title "></h4>            </div>
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
                    <th id="carStatus" onclick="sortAvail()">
                      Car Status
                    </th>
                  </thead>
                  <tbody id="data">
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
                                    {{-- hidden id --}}
                                    <input type="hidden" name="id" value="{{$car->id}}">
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
                                        <input type="carColor" name="carColor" class="form-control" id="carColor" value="{{old('carColor',$car->carColor)}}" placeholder="{{ $car->carColor}}">
                                    </div>
                                    <div class="form-group">
                                        {{-- plateNumber --}}
                                        <label for="plateNumber">{{__('Nomor Plat Mobil')}}</label>
                                        <input type="plateNumber" name="carPlateNumber" class="form-control" id="plateNumber" value="{{old('carPlateNumber',$car->carPlateNumber)}}" placeholder="{{ $car->carPlateNumber}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="carStatus">{{ __('Status Mobil') }}</label>
                                        <select class="form-control bg-dark" id="carStatus" name="carStatus">
                                            <option value="Available">Available</option>
                                            <option value="unavailable">Not Available</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="carImage-{{$car->id}}" class="d-flex justify-content-center">
                                            {{-- Jika user->avatar = null, maka tampilkan avatar default --}}
                                            @if ($car->carImage === '')
                                                    <img id="car-preview-{{$car->id}}"  class="carImage" src="{{ asset('storage/icons/upload.png') }}" alt="" style="height: 150px; width:75%">
                                            @else
                                                    <img id="car-preview-{{$car->id}}" class="carImage" src="{{ asset('storage/cars/'. $car->carImage) }}" alt="">
                                            @endif
                                            <input type="file" id="carImage-{{$car->id}}" name="carImage" accept="image/*" onchange="previewCar({{$car->carImage}});" hidden> <!-- Menggunakan 'photo' sebagai id dan name -->
                                        </label>
                                    </div>
                                </div>
                        </div>

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
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-center">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link" href="#" id="prev">Previous</a></li>
                                <li class="page-item"><a class="page-link" href="#" id="next">Next</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <x-modal title="Add Car" idModal="addCar" customStyle="">
    <form action="{{ route('admin.addAsset') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="carName">Car Name</label>
            <input type="text" name="carName" id="carName" class="form-control" placeholder="Car Name">
        </div>
        <div class="form-group">
            <label for="carModel">Car Model</label>
            <input type="text" name="carModel" id="carModel" class="form-control" placeholder="Car Model">
        </div>
        {{-- Selection Transmission --}}
        <div class="form-group">
            <label for="Transmission">Transmission</label>
            <select class="form-control bg-dark" id="Transmission" name="Transmission">
                <option value="automatic">Automatic</option>
                <option value="manual">Manual</option>
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
            <select class="form-control bg-dark" id="carStatus" name="carStatus">
                <option value="Available">Available</option>
                <option value="unAvailable">Not Available</option>
            </select>
        </div>
        {{-- Car Image --}}
        <div class="form-group">
            <label for="carImage">Car Image</label>
            <label for="carImage"><span id="fileName">(no file selected)</span></label>
            <input type="file" name="carImage" class="input-file text-light" id="carImage" onchange="updateFileName(this)">
        </div>
        <script>
            function updateFileName(input) {
                const fileNameSpan = document.getElementById('fileName');
                if (input.files.length > 0) {
                    fileNameSpan.textContent = input.files[0].name;
                } else {
                    fileNameSpan.textContent = '(no file selected)';
                }
            }
        </script>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</x-modal>
@endsection


@push('js')
<!-- ... Your HTML content ... -->
<script>
    function previewCar(id) {
    var input = document.getElementById('carImage'+id); // Menggunakan 'photo' sebagai id
    var imagePreview = document.getElementById('car-preview-'+id);

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            imagePreview.src = e.target.result;
        };

        reader.readAsDataURL(input.files[0]);
    }
}
</script>
    <script>

        function sortAvail() {
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementById("data");
            switching = true;
            /*Make a loop that will continue until
            no switching has been done:*/
            while (switching) {
            //start by saying: no switching is done:
            switching = false;
            rows = table.rows;
            /*Loop through all table rows (except the
            first, which contains table headers):*/
            // for (i = 1; i < (rows.length - 1); i++) {
            for (i = 1; i < (rows.length - 1); i++) {
                //start by saying there should be no switching:
                shouldSwitch = false;
                /*Get the two elements you want to compare,
                one from current row and one from the next:*/
                // x = rows[i].getElementsByTagName("TD")[0];
                // y = rows[i + 1].getElementsByTagName("TD")[0];
                x = rows[i].getElementsByTagName("TD")[6];
                y = rows[i + 1].getElementsByTagName("TD")[6];
                //check if the two rows should switch place:
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                //if so, mark as a switch and break the loop:
                shouldSwitch = true;
                break;
                }
            }
            if (shouldSwitch) {
                /*If a switch has been marked, make the switch
                and mark that a switch has been done:*/
                // rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
            }
        }

    </script>
@endpush
