@extends('adminlte::page')

@section('title', 'Equipos')

@section('content_header')
    <h1>Lista de Equipos</h1>
    <a href="{{ route('activos.create') }}" class="btn btn-success mb-2">Agregar Equipo</a>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Marca</th>
                <th>Tipo</th>
                <th>Serial</th>
                <th>SO</th>
                <th>Usuario</th>
                <th>Ubicación</th>
                <th>Valor</th>
                <th>Fecha Adq.</th>
                <th>Vida Útil</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($activos as $activo)
                <tr>
                    <td>{{ $activo->id }}</td>
                    <td>{{ $activo->marca_equipo ?? '-' }}</td>
                    <td>{{ $activo->tipo_equipo }}</td>
                    <td>{{ $activo->serial }}</td>
                    <td>{{ $activo->sistema_operativo }}</td>

                    {{-- Usuario responsable --}}
                    <td>{{ $activo->responsable->name ?? 'Sin asignar' }}</td>

                    {{-- Ubicación --}}
                    <td>{{ $activo->ubicacion->nombre ?? 'Sin ubicación' }}</td>

                    <td>${{ number_format($activo->valor_inicial, 2) }}</td>
                    <td>{{ $activo->fecha_adquisicion }}</td>
                    <td>{{ $activo->vida_util_estimada }}</td>

                    <td>
                        <a href="{{ route('activos.edit', $activo) }}" class="btn btn-primary btn-sm">Editar</a>

                        <form action="{{ route('activos.destroy', $activo) }}" 
                              method="POST" 
                              style="display:inline-block;">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Seguro que quieres eliminar este activo?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
