<h6 class="navbar-heading text-muted">
    @if(auth()->user()->role == 'admin')
        Gestion
    @else
        Menú
    @endif
</h6>
<ul class="navbar-nav">
    {{-- menu Administrador --}}
    @if(auth()->user()->role == 'admin')
        <li class="nav-item  active ">
            <a class="nav-link  active " href="{{url('/home')}}">
                <i class="ni ni-tv-2 text-danger"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{url('/especialidades')}}">
                <i class="ni ni-briefcase-24 text-blue"></i> Especialidades
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="/medicos">
                <i class="ni ni-pin-3 text-orange"></i> Medicos
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="/pacientes">
                <i class="ni ni-single-02 text-yellow"></i> Pacientes
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="/miscitas">
                <i class="ni ni-time-alarm text-blue"></i>Citas Medicas
            </a>
        </li>
        {{-- menu Doctor --}}
    @elseif(auth()->user()->role == 'doctor')
        <li class="nav-item">
            <a class="nav-link " href="/horario">
                <i class="ni ni-calendar-grid-58 text-yellow"></i> Gestionar horarios
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="/miscitas">
                <i class="ni ni-time-alarm text-blue"></i> Mis citas
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="">
                <i class="fas fa-bed text-success"></i> Mis Pacientes
            </a>
        </li>
    @else
    {{-- menu Pacientes --}}
        <li class="nav-item">
            <a class="nav-link " href="/resevarcitas">
                <i class="ni ni-calendar-grid-58 text-blue"></i> Reservar Cita
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="/miscitas">
                <i class="ni ni-folder-17 text-success"></i> Mis citas
            </a>
        </li>


    @endif

    <li class="nav-item">
      <a class="nav-link" href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('formLogout').submit()">
        <i class="ni ni-button-power text-danger"></i> Cerrar sesion
      </a>
        <form action="{{route('logout')}}" method="POST" style="display: none;" id="formLogout">
            @csrf
        </form>
    </li>
</ul>

@if(auth()->user()->role == 'admin')
    <!-- Divider -->
    <hr class="my-3">
    <!-- Heading -->
    <h6 class="navbar-heading text-muted">Reportes</h6>
    <!-- Navigation -->
    <ul class="navbar-nav mb-md-3">
    <li class="nav-item">
        <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/getting-started/overview.html">
        <i class="ni ni-spaceship"></i> Citas
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/foundation/colors.html">
        <i class="ni ni-palette"></i> Desempeño medico
        </a>
    </li>

    </ul>
@endif
