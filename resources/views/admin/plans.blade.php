@extends('layouts.app', ['pageSlug' => 'admin.plans'])

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            {{-- if any error and success --}}
            @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{session('status')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">
                        &times;
                    </span>
                </button>
            </div>
            @elseif(session('failed'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Failed!</strong> {{session('failed')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">
                        &times;
                    </span>
                </button>
            </div>
            @endif

            {{-- if any error validation --}}
          <div class="card">
            <div class="card-header card-header-primary">
                <div class="row">
                    <div class="col-10 d-flex">
                        Plans List
                    </div>
                    <div class="col">
                        <a href="route('admin.plans.create')" class="btn btn-info btn-round" data-toggle="modal" data-target="#plan">Add Plan</a>
                    </div>
                </div>
                <div class="row">
                    <div class="container-fluid">
                        <div class="col-md-4">
                            <div class="searchInput">
                                <input type="text" name="search" id="searchInput" class="form-control" placeholder="Search Plan">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                    <thead class="text-primary">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Session</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        @foreach ($plans as $plan)
                        <tr>
                            <td>{{ $plan->id }}</td>
                            <td>{{ $plan->planName }}</td>
                            <td>{{ $plan->planSession }}</td>
                            <td>{{ $plan->planType }}</td>
                            <td>{{ $plan->planPrice }}</td>
                            <td>{{ $plan->planDescription }}</td>
                            {{-- 1 = active / 0 = inactive --}}
                            <td>
                                @if ($plan->planStatus == 1)
                                <span class="badge badge-success">Active</span>
                                @else
                                <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="#" rel="tooltip" class="btn btn-info btn-sm btn-round btn-icon"
                                data-toggle="modal" data-target="#plan{{ $plan->id }}" data-placement="top" title="Data Plan"
                                data-planID="{{ $plan->id }}">
                                <i class="tim-icons icon-single-02"></i>
                                </a>
                            </td>
                        </tr>

                        <x-modal title="Data Plan" idModal="plan{{$plan->id}}" customStyle="modal-lg">
                            <form action="{{route('admin.updatePlan')}}" method="post">
                                @method('put')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="planName">Plan Name</label>
                                            <input type="text" name="planName" id="planName" value="{{old('planName',$plan->planName)}}" class="form-control" placeholder="Plan Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="planSession">Plan Session</label>
                                            <input type="text" name="planSession" id="planSession" value="{{old('planSession',$plan->planSession)}}" class="form-control" placeholder="Plan Session">
                                        </div>
                                        <div class="form-group">
                                            <label for="planType">Plan Type</label>
                                            <input type="text" name="planType" id="planType" value="{{old('planType',$plan->planType)}}" class="form-control" placeholder="Plan Type">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="planPrice">Plan Price</label>
                                            <input type="text" name="planPrice" id="planPrice" value="{{old('planPrice',$plan->planPrice)}}" class="form-control" placeholder="Plan Price">
                                        </div>
                                        <div class="form-group">
                                            <label for="planDescription">Plan Description</label>
                                            <input type="text" name="planDescription" id="planDescription" value="{{old('planDescription',$plan->planDescription)}}" class="form-control" placeholder="Plan Description">
                                        </div>
                                        <div class="form-group">
                                            <label for="planStatus">Plan Status</label>
                                            <input type="text" name="planStatus" id="planStatus" class="form-control" value="{{old('planStatus',$plan->planStatus)}}" placeholder="Plan Status">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        @csrf
                                        <input type="hidden" name="planID" value="{{$plan->id}}">
                                        <button type="submit" class="btn btn-primary btn-round btn-block">Update Plan</button>
                                    </div>
                                </div>
                            </form>
                        </x-modal>
                        @endforeach
                    </tbody>
                </table>
                <p id="noDataFoundMessage" style="display: none; color: red;">Data not Found</p>


                <nav aria-label="...">
                    <ul class="pagination">
                      <!-- Tombol Previous -->
                      @if ($plans->onFirstPage())
                      <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Sebelumnya</a>
                      </li>
                      @else
                      <li class="page-item">
                        <a class="page-link" href="{{ $plans->previousPageUrl() }}" tabindex="-1">Sebelumnya</a>
                      </li>
                      @endif

                      <!-- Tombol halaman -->
                      @foreach ($plans->getUrlRange(1, $plans->lastPage()) as $page => $url)
                      <li class="page-item{{ ($plans->currentPage() == $page) ? ' active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                      </li>
                      @endforeach
                      <!-- Tombol Next -->
                      @if ($plans->hasMorePages())
                      <li class="page-item">
                        <a class="page-link" href="{{ $plans->nextPageUrl() }}">Selanjutnya</a>
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

    <x-modal title="Add plan" idModal="plan" customStyle="">
        <x-form action="{{ route('admin.addPlan') }}" method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="planName">Plan Name</label>
                        <input type="text" name="planName" id="planName" value="{{old($plan->planName)}}" class="form-control" placeholder="Plan Name">
                    </div>
                    <div class="form-group">
                        <label for="planSession">Plan Session</label>
                        <input type="text" name="planSession" id="planSession" value="{{old($plan->planSession)}}" class="form-control" placeholder="Plan Session">
                    </div>
                    <div class="form-group">
                        <label for="planType">Plan Type</label>
                        <input type="text" name="planType" id="planType" value="{{old($plan->planType)}}" class="form-control" placeholder="Plan Type">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="planPrice">Plan Price</label>
                        <input type="text" name="planPrice" id="planPrice" value="{{old($plan->planPrice)}}" class="form-control" placeholder="Plan Price">
                    </div>
                    <div class="form-group">
                        <label for="planDescription">Plan Description</label>
                        <input type="text" name="planDescription" id="planDescription" value="{{old($plan->planDescription)}}" class="form-control" placeholder="Plan Description">
                    </div>
                    <div class="form-group">
                        <label for="planStatus">Plan Status</label>
                        <input type="text" name="planStatus" id="planStatus" class="form-control" value="{{old($plan->planStatus)}}" placeholder="Plan Status">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-round btn-block">Add Plan</button>
                </div>
            </div>
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
