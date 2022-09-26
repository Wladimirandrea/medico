<?php
    use Illuminate\Support\Str;
?>

@extends('layouts.panel')

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endsection

@section('content')

      <div class="card shadow">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col">
              <h3 class="mb-0">Editar Medico</h3>
            </div>
            <div class="col text-right">
              <a href="{{url('/medicos')}}" class="btn btn-sm btn-primary">regresar</a>
            </div>
          </div>
        </div>
        <div class="card-body">

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                        <strong>Por favor</strong> {{$error}}
                    </div>
                @endforeach

            @endif
            <form method="POST" action="{{ url('/medicos/'.$doctor->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">nombre del medico</label>
                    <input type="text" name="name" class="form-control" value="{{old('name', $doctor->name)}}" >
                </div>
                <div class="form-group">
                    <label for="specialties">Especialidades</label>
                    <select name="specialties[]" id="specialties" class="form-control selectpicker" data-style="btn-primary" title="Seleccionar especialidades" multiple required>
                        @foreach ($specialties as $especialidad)
                            <option value="{{$especialidad->id}}">{{$especialidad->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">correo electronico</label>
                    <input type="text" name="email" class="form-control" value="{{old('email', $doctor->email)}}">

                </div>
                <div class="form-group">
                    <label for="cedula">cedula</label>
                    <input type="text" name="cedula" class="form-control" value="{{old('cedula', $doctor->cedula)}}">
                </div>
                <div class="form-group">
                    <label for="address">direccion</label>
                    <input type="text" name="address" class="form-control" value="{{old('address', $doctor->address)}}">

                </div>
                <div class="form-group">
                    <label for="phone">Telefono</label>
                    <input type="text" name="phone" class="form-control" value="{{old('phone', $doctor->phone)}}">
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="text" name="password" class="form-control">
                    <small class="text-warning">Solo llena el campo si deseas cambia la contraseña</small>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">crear</button>
            </form>
        </div>
      </div>
    </div>

</div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(()=>{});
        $('#specialties').selectpicker('val', @json($specialty_ids));
    </script>
@endsection
