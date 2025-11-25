@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Paso 1: Monitor asignado</h3>

    <form action="{{ route('equipos.wizard.saveMonitor') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Marca</label>
            <input type="text" class="form-control" name="marca" value="{{ old('marca') }}">
            @error('marca') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label>Modelo</label>
            <input type="text" class="form-control" name="modelo" value="{{ old('modelo') }}">
            @error('modelo') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label>Pulgadas</label>
            <input type="number" class="form-control" name="pulgadas" value="{{ old('pulgadas') }}">
            @error('pulgadas') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button class="btn btn-primary">Guardar y continuar</button>
    </form>
</div>
@endsection
