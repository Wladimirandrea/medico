<?php
    use Illuminate\Support\Str;
?>
@extends('layouts.panel')

@section('content')

      <div class="card shadow">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col">
              <h3 class="mb-0">Nuevo Paciente</h3>
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
            <form method="POST" action="{{ url('/pacientes') }}">
                @csrf
                <div class="form-group">
                    <label for="name">nombre del paciente</label>
                    <input type="text" name="name" class="form-control" value="{{old('name')}}" required>
                </div>
                <div class="form-group">
                    <label for="email">correo electronico</label>
                    <input type="text" name="email" class="form-control" value="{{old('email')}}" required>

                </div>
                <div class="form-group">
                    <label for="cedula">cedula</label>
                    <input type="text" name="cedula" class="form-control" value="{{old('cedula')}}" required>
                </div>
                <div class="form-group">
                    <label for="address">direccion</label>
                    <input type="text" name="address" class="form-control" value="{{old('address')}}" required>

                </div>
                <div class="form-group">
                    <label for="phone">Telefono</label>
                    <input type="text" name="phone" class="form-control" value="{{old('phone')}}" required>

                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="text" name="password" class="form-control" value="{{old('password', Str::random(8))}}" required>

                </div>
                <button type="submit" class="btn btn-sm btn-primary">crear</button>
            </form>
        </div>
      </div>
    </div>

</div>
@endsection
