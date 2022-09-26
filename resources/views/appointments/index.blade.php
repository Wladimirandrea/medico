@extends('layouts.panel')

@section('content')

      <div class="card shadow">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col">
              <h3 class="mb-0">Mis Citas</h3>
            </div>

          </div>
        </div>

        <div class="card-body">
          @if (session('notification'))
            <div class="alert alert-success" role="alert">
              {{session('notification')}}
            </div>
          @endif


            <div class="nav-wrapper">
                <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 active" data-toggle="tab" href="#mis-citas" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><i class="ni ni-cloud-upload-96 mr-2"></i>Mis Citas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" data-toggle="tab" href="#citas-pendientes" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><i class="ni ni-bell-55 mr-2"></i>Pendientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" data-toggle="tab" href="#historial" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false"><i class="ni ni-calendar-grid-58 mr-2"></i>Historial</a>
                    </li>
                </ul>
            </div>
            <div class="card shadow">
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="mis-citas" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                            @include('appointments.confirmed-appointments')
                        </div>
                        <div class="tab-pane fade" id="citas-pendientes" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                            @include('appointments.pending-appointments')
                        </div>
                        <div class="tab-pane fade" id="historial" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                            @include('appointments.old-appointments')
                        </div>
                    </div>
                </div>
            </div>

        </div>

      </div>
    </div>
   {{--  <div class="card-body">
        {{$doctors->links()}}
    </div> --}}

</div>
@endsection
