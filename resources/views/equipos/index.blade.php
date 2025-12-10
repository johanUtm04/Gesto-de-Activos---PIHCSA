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
<div class="table-responsive">
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
                <th>Periféricos</th>
                <th>Procesadores</th>
                
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

                    {{-- USUARIO --}}
                    <td>
                        <strong>{{ $equipo->usuario->name ?? 'Sin asignar' }}</strong>
                        <br>
                        <small>{{ $equipo->usuario->email ?? '-' }}</small>
                    </td>

                    {{-- UBICACIÓN --}}
                    <td>
                        <strong>{{ $equipo->ubicacion->nombre ?? 'Sin ubicación' }}</strong>
                        <br>
                        <small>{{ $equipo->ubicacion->codigo ?? '-' }}</small>
                    </td>

                    <td>${{ number_format($equipo->valor_inicial, 2) }}</td>
                    <td>{{ $equipo->fecha_adquisicion }}</td>
                    <td>{{ $equipo->vida_util_estimada }}</td>
                    
                    <td>
                        @if($equipo->monitores->isNotEmpty())
                            <strong>{{ $equipo->monitores->count() }} Monitor(es)</strong>
                            <br>
                            <small>Marcas: {{ $equipo->monitores->pluck('marca')->implode(', ') }}</small>
                        @else
                            Sin Monitor
                        @endif
                    </td>
                    
                    <td>
                        @if($equipo->discosDuros->isNotEmpty())
                            <strong>{{ $equipo->discosDuros->count() }} Disco(s)</strong>
                            <br>
                            <small>Capacidad: {{ $equipo->discosDuros->pluck('capacidad')->implode(' + ') }}</small>
                        @else
                            Sin Disco Duro
                        @endif
                    </td>
                    
                    <td>
                        @if($equipo->rams->isNotEmpty())
                            <strong>{{ $equipo->rams->count() }} Módulo(s)</strong>
                            <br>
                            <small>Total: {{ $equipo->rams->pluck('capacidad_gb') }} GB</small>
                        @else
                            Sin RAM
                        @endif
                    </td>
                    
                    <td>
                        @if($equipo->perifericos->isNotEmpty())
                            <strong>{{ $equipo->perifericos->count() }} Periférico(s)</strong>
                            <br>
                            <small>Tipos: {{ $equipo->perifericos->pluck('tipo')->implode(', ') }}</small>
                        @else
                            Sin Periférico
                        @endif
                    </td>
                    
                    <td>
                        @if($equipo->procesadores->isNotEmpty())
                            <strong>{{ $equipo->procesadores->count() }} Procesador(es)</strong>
                            <br>
                            <small>Marca: {{ $equipo->procesadores->first()->marca ?? 'N/A' }}</small>
                        @else
                            Sin Procesador
                        @endif
                    </td>

                    {{-- Acciones --}}
                    <td>
                        <a href="{{ route('equipos.edit', $equipo) }}" class="btn btn-primary btn-sm">Ver</a>
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
                        <a href="{{ route('equipos.edit', $equipo) }}" class="btn btn-primary btn-sm">Registrar un mantenimiento</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
@stop