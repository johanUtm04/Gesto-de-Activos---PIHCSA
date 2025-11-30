@extends('adminlte::page')

@section('title', 'Equipos')

@section('content_header')
    <h1>Lista de Equipos</h1>
    <a href="{{ route('equipos.create') }}" class="btn btn-success mb-2">Agregar Equipo</a>
@stop

@section('content')
    @php
        $alertTypes = ['success', 'danger', 'warning', 'info', 'primary'];
    @endphp

    @foreach ($alertTypes as $msg)
        @if(Session::has($msg))
            <div class="alert alert-{{ $msg }} alert-dismissible fade show" role="alert">
                {{ Session::get($msg) }}
            </div>
        @endif
    @endforeach

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
            @foreach($equipos as $equipo)
                <tr>
                    <td>{{ $equipo->id }}</td>
                    <td>{{ $equipo->marca_equipo ?? '-' }}</td>
                    <td>{{ $equipo->tipo_equipo }}</td>
                    <td>{{ $equipo->serial }}</td>
                    <td>{{ $equipo->sistema_operativo }}</td>

                    {{-- Usuario responsable --}}
                    <td>{{ $equipo->responsable->name ?? 'Sin asignar' }}</td>

                    {{-- Ubicación --}}
                    <td>{{ $equipo->ubicacion->nombre ?? 'Sin ubicación' }}</td>

                    <td>${{ number_format($equipo->valor_inicial, 2) }}</td>
                    <td>{{ $equipo->fecha_adquisicion }}</td>
                    <td>{{ $equipo->vida_util_estimada }}</td>

                    <td>
                        <a href="{{ route('equipos.edit', $equipo) }}" class="btn btn-primary btn-sm">Editar</a>

                        <form action="{{ route('equipos.destroy', $equipo) }}" 
                              method="POST" 
                              style="display:inline-block;">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Seguro que quieres eliminar este equipo?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
