@extends('adminlte::page')

@section('content')
<div class="container">
    <h3>Disco Duro</h3>

    <form action="{{ route('equipos.wizard.saveDiscoduro', $equipo) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Capacidad</label>
            <input type="text" class="form-control" name="capacidad" value="{{ old('capacidad') }}">
            @error('caoacidad') <span class="text-danger">{{ $message }}</span> @enderror
        </div>


        <div class="mb-3">
            <label>	Tipo_hdd_ssd</label>
            <input type="text" class="form-control" name="tipo_hdd_ssd" value="{{ old('tipo_hdd_ssd') }}">
            @error('tipo_hdd_ssd') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label>Interface</label>
            <input type="text" class="form-control" name="interface" value="{{ old('interface') }}">
            @error('interface') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button class="btn btn-primary">Guardar y continuar</button>
    </form>
</div>
@endsection
