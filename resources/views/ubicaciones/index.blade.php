@extends('adminlte::page')

@section('title', 'Gestión de Ubicaciones')

@section('css')
<style>
    .table-ubicaciones thead th {
        background-color: #fdecea;
        color: #dc3545; 
        font-weight: 900;
        border-bottom: 3px solid #dc3545;
        vertical-align: middle;
        padding: 10px;
    }

    .table-ubicaciones tbody td {
        vertical-align: top;
        font-size: 17px;
        line-height: 1.4;
    }

    .secondary-data {
        color: #6c757d;
        font-size: 0.85em;
        display: block;
    }

    .table td .badge {
        font-weight: 500;
        padding: 6px 8px;
    }
</style>
@stop


@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="mb-0">
            <i class="fas fa-map-marker-alt text-danger"></i> Gestión de Ubicaciones
        </h1>
        <small class="text-muted">
            Control y administración de ubicaciones físicas
        </small>
    </div>

    <div class="btn-group">
        <a href="{{ route('ubicaciones.create') }}" class="btn btn-danger">
            <i class="fas fa-plus"></i> Agregar Ubicacion
        </a>
    </div>


</div>
@stop


@section('content')

{{-- Alertas AdminLTE --}}
@php
    $alertTypes = ['success', 'danger', 'warning', 'info', 'primary'];
@endphp

@foreach ($alertTypes as $msg)
    @if(Session::has($msg))
        <div class="alert alert-{{ $msg }} alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            {{ Session::get($msg) }}
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
@endforeach


<div class="card">
    <div class="card-body">
        <div class="table-responsive">

            <table class="table table-bordered table-hover table-ubicaciones">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th><i class="fas fa-map"></i> Ubicación</th>
                        <th><i class="fas fa-barcode"></i> Código</th>
                        <th class="text-center"><i class="fas fa-cogs"></i> Acciones</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($ubicaciones as $ubicacion)
                    <tr>
                        <td>{{ $ubicacion->id }}</td>

                        {{-- UBICACIÓN --}}
                        <td>
                            <strong>{{ $ubicacion->nombre }}</strong>
                            <span class="secondary-data">
                                <i class="fas fa-door-open"></i> Ubicación física
                            </span>
                        </td>

                        {{-- CÓDIGO --}}
                        <td>
                            <span class="badge badge-light">
                                <i class="fas fa-hashtag"></i> {{ $ubicacion->codigo }}
                            </span>
                        </td>

                        {{-- ACCIONES --}}
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">

                                <a href="{{ route('ubicaciones.edit', $ubicacion) }}"
                                   class="btn btn-outline-danger"
                                   title="Editar Ubicación">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <form action="{{ route('ubicaciones.destroy', $ubicacion) }}"
                                      method="POST"
                                      style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-secondary"
                                            title="Eliminar Ubicación"
                                            onclick="return confirm('¿Eliminar la ubicación {{ $ubicacion->nombre }}?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            <i class="fas fa-map-marked-alt fa-2x mb-2"></i><br>
                            No hay ubicaciones registradas
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {{-- Paginación --}}
            <div class="mt-3">
                {{ $ubicaciones->links() }}
            </div>

        </div>
    </div>
</div>

@endsection


@section('footer')
<footer class="main-footer text-sm">
    <div class="float-right d-none d-sm-inline">
        <i class="fas fa-code"></i> PIHCSA · Gestion de Activos
    </div>

    <strong>
        <i class="fas fa-boxes"></i> Inventario de Activos TI
    </strong>
    &copy; {{ date('Y') }} |
    Desarrollado por <strong>Johan</strong>

</footer>
@endsection