@extends('layouts.panel')

@section('content')

      <div class="card shadow">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col">
              <h3 class="mb-0">Nueva Especialidad</h3>
            </div>
            <div class="col text-right">
              <a href="{{url('/especialidades')}}" class="btn btn-sm btn-primary">regresar</a>
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
            <form method="POST" action="{{ url('/especialidades') }}">
                @csrf
                <div class="form-group">
                    <label for="name">nombre especialidad</label>
                    <input type="text" name="name" class="form-control" value="{{old('name')}}" required>
                </div>
                <div class="form-group">
                    <label for="description">descripcion especialidad</label>
                    <input type="text" name="description" class="form-control" value="{{old('description')}}" required>

                </div>
                <button type="submit" class="btn btn-sm btn-primary">crear</button>
            </form>
        </div>
      </div>
    </div>

</div>
@endsection
