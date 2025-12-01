@extends('adminlte::page')

@section('content')
<div class="container">
    <h3>Periferico</h3>

    <form action="{{ route('equipos.wizard.savePeriferico', $equipo) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Tipo</label>
            <input type="text" class="form-control" name="tipo" value="{{ old('tipo') }}">
            @error('tipo') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label>Marca</label>
            <input type="text" class="form-control" name="marca" value="{{ old('marca') }}">
            @error('marca') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label>Serial</label>
            <input type="text" class="form-control" name="serial" value="{{ old('serial') }}">
            @error('serial') <span class="text-danger">{{ $message }}</span> @enderror
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
