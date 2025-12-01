@extends('adminlte::page')

@section('content')
    <div class="container">
        <h3>Asignar Ubicación a: {{ $equipo->serial }}</h3>

        <form action="{{ route('equipos.wizard.saveUbicacion', $equipo) }}" method="POST">
            @csrf

            <label>Ubicación</label>
            <select name="ubicacion_id" class="form-control">
                @foreach(\App\Models\Ubicacion::all() as $ubicacion)
                    <option value="{{ $ubicacion->id }}">{{ $ubicacion->nombre }}</option>
                @endforeach
            </select>

            <br>

            <button class="btn btn-primary">Guardar y continuar</button>

        </form>
    </div>
@endsection
