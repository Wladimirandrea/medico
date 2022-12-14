<?php
    use Illuminate\Support\Str;
?>

@extends('layouts.panel')

@section('content')

      <div class="card shadow">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col">
              <h3 class="mb-0">Editar Paciente</h3>
            </div>
            <div class="col text-right">
              <a href="{{url('/pacientes')}}" class="btn btn-sm btn-primary">regresar</a>
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
            <form method="POST" action="{{ url('/pacientes/'.$patient->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">nombre del medico</label>
                    <input type="text" name="name" class="form-control" value="{{old('name', $patient->name)}}" >
                </div>
                <div class="form-group">
                    <label for="email">correo electronico</label>
                    <input type="text" name="email" class="form-control" value="{{old('email', $patient->email)}}">

                </div>
                <div class="form-group">
                    <label for="cedula">cedula</label>
                    <input type="text" name="cedula" class="form-control" value="{{old('cedula', $patient->cedula)}}">
                </div>
                <div class="form-group">
                    <label for="address">direccion</label>
                    <input type="text" name="address" class="form-control" value="{{old('address', $patient->address)}}">

                </div>
                <div class="form-group">
                    <label for="phone">Telefono</label>
                    <input type="text" name="phone" class="form-control" value="{{old('phone', $patient->phone)}}">
                </div>
                <div class="form-group">
                    <label for="password">Contrase??a</label>
                    <input type="text" name="password" class="form-control">
                    <small class="text-warning">Solo llena el campo si deseas cambia la contrase??a</small>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">crear</button>
            </form>
        </div>
      </div>
    </div>

</div>
@endsection
