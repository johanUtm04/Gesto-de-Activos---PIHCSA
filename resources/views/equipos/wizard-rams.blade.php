@extends('adminlte::page')

@section('content')
<div class="container">
    <h3>RAM</h3>

    <form action="{{ route('equipos.wizard.saveRam', $equipo) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Capacidad en GB</label>
            <input type="text" class="form-control" name="capacidad_gb" value="{{ old('capacidad_gb') }}">
            @error('capacidad_gb') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label>Clock_m hz</label>
            <input type="text" class="form-control" name="clock_m" value="{{ old('clock_m') }}">
            @error('clock_m,hz') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label>Tipo_chz</label>
            <input type="text" class="form-control" name="tipo_chz" value="{{ old('tipo_chz') }}">
            @error('tipo_chz') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button class="btn btn-primary">Guardar y continuar</button>
    </form>
</div>
@endsection
