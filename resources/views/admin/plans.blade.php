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
                        <a href="route('admin.plans.create')" class="btn btn-primary btn-round" data-toggle="modal" data-target="#plan">Add Plan</a>
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
                        <th>Action</th>
                    </thead>
                    <tbody id="data">
                        @foreach ($plans as $plan)
                        <tr>
                            <td>{{ $plan->id }}</td>
                            <td>{{ $plan->planName }}</td>
                            <td>{{ $plan->planSession }}</td>
                            <td>{{ $plan->planType }}</td>
                            <td>Rp. {{number_format($plan->planPrice, 0, ',', '.')}}</td>
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
                                            <label for="planName" class="text-dark">Plan Name</label>
                                            <input type="text" name="planName" id="planName" value="{{old('planName',$plan->planName)}}" class="text-dark form-control" placeholder="Plan Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="planSession" class="text-dark">Plan Session</label>
                                            <input type="text" name="planSession" id="planSession" value="{{old('planSession',$plan->planSession)}}" class="text-dark form-control" placeholder="Plan Session">
                                        </div>
                                        <div class="form-group">
                                            <label for="planType" class="text-dark">Plan Type</label>
                                            <input type="text" name="planType" id="planType" value="{{old('planType',$plan->planType)}}" class="text-dark form-control" placeholder="Plan Type">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="planPrice" class="text-dark">Plan Price</label>
                                            <input type="text" name="planPrice" id="planPrice" value="{{old('planPrice',$plan->planPrice)}}" class="text-dark form-control" placeholder="Plan Price">
                                        </div>
                                        <div class="form-group">
                                            <label for="planDescription" class="text-dark">Plan Description</label>
                                            <input type="text" name="planDescription" id="planDescription" value="{{old('planDescription',$plan->planDescription)}}" class="text-dark form-control" placeholder="Plan Description">
                                        </div>
                                        <div class="form-group">
                                            <label for="planStatus" class="text-dark">Plan Status</label>
                                            {{-- dropdown 1/0 --}}
                                            <select name="planStatus" id="planStatus" class="text-dark form-control">
                                                <option value="1" {{old('planStatus',$plan->planStatus) == 1 ? 'selected' : ''}}>Active</option>
                                                <option value="0" {{old('planStatus',$plan->planStatus) == 0 ? 'selected' : ''}}>Inactive</option>
                                            </select>
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
                        {{-- dropdown --}}
                        <select name="planStatus" id="planStatus" class="form-control text-dark">
                            <option value="1" {{old($plan->planStatus) == 1 ? 'selected' : ''}}>Active</option>
                            <option value="0" {{old($plan->planStatus) == 0 ? 'selected' : ''}}>Inactive</option>
                        </select>
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
