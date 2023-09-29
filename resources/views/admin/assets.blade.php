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
                            <button type="button" rel="tooltip" class="btn btn-info btn-sm btn-round btn-icon">
                                <i class="tim-icons icon-single-02"></i>
                            </button>
                            <button type="button" rel="tooltip" class="btn btn-success btn-sm btn-round btn-icon">
                                <i class="tim-icons icon-settings"></i>
                            </button>
                            <button type="button" rel="tooltip" class="btn btn-danger btn-sm btn-round btn-icon">
                                <i class="tim-icons icon-simple-remove"></i>
                            </button>
                          </td>
                    </tr>
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
