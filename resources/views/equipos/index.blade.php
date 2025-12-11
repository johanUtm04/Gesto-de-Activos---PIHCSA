@extends('adminlte::page')

@section('title', 'Gestion de Activos')

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
        <!-- Encabezados -->
        <thead>
            <tr>
                <th style="background:#f5f7fa;color:#2d3e50;padding:12px;border-bottom:3px solid #4A90E2;font-size:14px;font-weight:600;">ID</th>
                <th style="background:#f5f7fa;color:#2d3e50;padding:12px;border-bottom:3px solid #0077CC;font-size:14px;font-weight:600;">Marca</th>
                <th style="background:#f5f7fa;color:#2d3e50;padding:12px;border-bottom:3px solid #005FB8;font-size:14px;font-weight:600;">Tipo</th>

                <th style="background:#f5f7fa;color:#2d3e50;padding:12px;border-bottom:3px solid #4A90E2;font-size:14px;font-weight:600;">Serial</th>
                <th style="background:#f5f7fa;color:#2d3e50;padding:12px;border-bottom:3px solid #0077CC;font-size:14px;font-weight:600;">SO</th>

                <th style="background:#f5f7fa;color:#2d3e50;padding:12px;border-bottom:3px solid #005FB8;font-size:14px;font-weight:600;">USUARIO</th>
                <th style="background:#f5f7fa;color:#2d3e50;padding:12px;border-bottom:3px solid #4A90E2;font-size:14px;font-weight:600;">UBICACIÓN</th>

                <th style="background:#f5f7fa;color:#2d3e50;padding:12px;border-bottom:3px solid #0077CC;font-size:14px;font-weight:600;">Valor Inicial</th>
                <th style="background:#f5f7fa;color:#2d3e50;padding:12px;border-bottom:3px solid #005FB8;font-size:14px;font-weight:600;">Fecha Adq.</th>
                <th style="background:#f5f7fa;color:#2d3e50;padding:12px;border-bottom:3px solid #4A90E2;font-size:14px;font-weight:600;">Vida Útil Estimada</th>

                <th style="background:#f5f7fa;color:#2d3e50;padding:12px;border-bottom:3px solid #0077CC;font-size:14px;font-weight:600;">Monitores</th>
                <th style="background:#f5f7fa;color:#2d3e50;padding:12px;border-bottom:3px solid #005FB8;font-size:14px;font-weight:600;">Discos Duros</th>
                <th style="background:#f5f7fa;color:#2d3e50;padding:12px;border-bottom:3px solid #4A90E2;font-size:14px;font-weight:600;">RAM</th>

                <th style="background:#f5f7fa;color:#2d3e50;padding:12px;border-bottom:3px solid #0077CC;font-size:14px;font-weight:600;">Periféricos</th>
                <th style="background:#f5f7fa;color:#2d3e50;padding:12px;border-bottom:3px solid #005FB8;font-size:14px;font-weight:600;">Procesadores</th>

                <th style="background:#f5f7fa;color:#2d3e50;padding:12px;border-bottom:3px solid #4A90E2;font-size:14px;font-weight:600;">Acciones</th>
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
                    <div>
                    <td style="border: 2px solid green">
                        <a href="{{ route('equipos.edit', $equipo) }}" class="btn btn-outline-primary">Ver</a>
                         <a href="{{ route('equipos.edit', $equipo) }}" class="btn btn-outline-warning">Editar</a>
                        <form action="{{ route('equipos.destroy', $equipo) }}" 
                              method="POST" 
                              style="display:inline-block;">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-outline-danger"
                                onclick="return confirm('¿Seguro que quieres eliminar este equipo y todos sus componentes asociados?')">
                                Eliminar
                            </button>
                        </form>
                        <a href="{{ route('equipos.edit', $equipo) }}" class="btn btn-outline-info">Registrar un mantenimiento</a>
                    </td>
                    </div>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
@stop