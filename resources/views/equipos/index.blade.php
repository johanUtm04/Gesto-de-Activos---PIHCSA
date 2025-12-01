@extends('adminlte::page')

@section('title', 'Equipos')

@section('content_header')
    <h1>Lista de Equipos</h1>
    <a href="{{ route('equipos.create') }}" class="btn btn-success mb-2">Agregar Equipo</a>
@stop

@section('content')
    {{-- Manejo de Mensajes de Sesión (Alertas) --}}
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
                
                <th>USUARIO</th> 
                
                <th>UBICACIÓN</th> 
                
                <th>Valor Inicial</th>
                <th>Fecha Adq.</th>
                <th>Vida Útil Estimada</th>
                <th>Monitores</th>
                <th>Discos Duros</th>
                <th>RAM</th>
                <!-- <th>Perifericos</th>
                <th>Procesadores</th> -->
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

                    <td>
                        <strong>{{ $equipo->usuario->name ?? 'Sin asignar' }}</strong>
                        <br>
                        <small>{{ $equipo->usuario->email ?? '-' }}</small>
                    </td>

                    <td>
                        <strong>{{ $equipo->ubicacion->nombre ?? 'Sin Monitor' }}</strong>
                        <br>
                        <small>{{ $equipo->ubicacion->codigo ?? '-' }}</small>
                    </td>

                    <td>${{ number_format($equipo->valor_inicial, 2) }}</td>
                    <td>{{ $equipo->fecha_adquisicion }}</td>
                    <td>{{ $equipo->vida_util_estimada }}</td>
                    <!-- MONITOR -->
                    <td>
                        <strong>{{ $equipo->monitor->marca ?? 'Sin Monitor' }}</strong>
                        <br>
                        <small>{{ $equipo->monitor->serial ?? '-' }}</small>
                    </td>
                    <!-- DISCO DURO -->
                    <td>
                        <strong>{{ $equipo->discoDuro->marca ?? 'Sin discoDuro' }}</strong>
                        <br>
                        <small>{{ $equipo->discoDuro->serial ?? '-' }}</small>
                    </td>
                    <!-- RAM -->
                    <td>
                        <strong>{{ $equipo->ram->marca ?? 'Sin ram' }}</strong>
                        <br>
                        <small>{{ $equipo->ram->serial ?? '-' }}</small>
                    </td>

                    
                    <!-- Acciones -->
                    <td>
                        <a href="{{ route('equipos.edit', $equipo) }}" class="btn btn-primary btn-sm">Editar</a>
                        
                        <form action="{{ route('equipos.destroy', $equipo) }}" 
                              method="POST" 
                              style="display:inline-block;">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Seguro que quieres eliminar este equipo y todos sus componentes asociados?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop