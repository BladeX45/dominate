@extends('layouts.app', ['pageSlug' => 'admin.plans'])

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
                <div class="row">
                    <div class="col-10 d-flex">
                        Plans List
                    </div>
                    <div class="col">
                        <a href="route('admin.plans.create')" class="btn btn-info btn-round" data-toggle="modal" data-target="#exampleModal">Add Plan</a>
                    </div>
                </div>
              <h4 class="card-title ">Plans Table</h4>
              <p class="card-category"> Here is a subtitle for this table</p>

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
                                <a href="{{ route('admin.updatePlan', ['id' => $plan->id]) }}" rel="tooltip" class="btn btn-success btn-sm btn-round btn-icon"
                                    data-toggle="tooltip" data-placement="top" title="Update">
                                    <i class="tim-icons icon-settings"></i>
                                </a>
                                <form action="{{ route('admin.deletePlan', ['id' => $plan->id]) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" rel="tooltip" class="btn btn-danger btn-sm btn-round btn-icon"
                                        data-toggle="tooltip" data-placement="top" title="Hapus">
                                        <i class="tim-icons icon-simple-remove"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>


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
            <div class="form-group">
                <label for="planName">Plan Name</label>
                <input type="text" name="planName" id="planName" class="form-control" placeholder="Plan Name">
            </div>
            <div class="form-group">
                <label for="planSession">Plan Session</label>
                <input type="text" name="planSession" id="planSession" class="form-control" placeholder="Plan Session">
            </div>
            <div class="form-group">
                <label for="planType">Plan Type</label>
                <input type="text" name="planType" id="planType" class="form-control" placeholder="Plan Type">
            </div>
            <div class="form-group">
                <label for="planPrice">Plan Price</label>
                <input type="text" name="planPrice" id="planPrice" class="form-control" placeholder="Plan Price">
            </div>
            <div class="form-group">
                <label for="planDescription">Plan Description</label>
                <input type="text" name="planDescription" id="planDescription" class="form-control" placeholder="Plan Description">
            </div>
            <div class="form-group">
                <label for="planStatus">Plan Status</label>
                <input type="text" name="planStatus" id="planStatus" class="form-control" placeholder="Plan Status">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
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
