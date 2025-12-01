@extends('adminlte::page')

@section('content')
<div class="container">
    <h3>Periferico</h3>

    <form action="{{ route('equipos.wizard.saveProcesador', $equipo) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Marca</label>
            <input type="text" class="form-control" name="marca" value="{{ old('marca') }}">
            @error('marca') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label>Tipo (descripcion)</label>
            <input type="text" class="form-control" name="descripcion_tipo" value="{{ old('descripcion_tipo') }}">
            @error('descripcion_tipo') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button class="btn btn-primary">Guardar y continuar</button>
    </form>
</div>
@endsection
