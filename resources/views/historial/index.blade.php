@extends('adminlte::page')

@section('title', 'Historial de Acciones')

@section('css')
<style>
    .log-card {
        border-left: 4px solid #17a2b8;
    }

    .log-type {
        font-weight: 600;
        letter-spacing: .5px;
    }

    .log-json {
        background-color: #f8f9fa;
        border-radius: .25rem;
        padding: 10px;
        font-size: .85rem;
        max-height: 160px;
        overflow-y: auto;
        border: 1px solid #dee2e6;
    }

    .table-assets th {
        background-color: #f4f6f9;
        font-weight: 600;
    }

    .badge-module {
        background-color: #6c757d;
    }

    .badge-action {
        background-color: #007bff;
    }

    .log-date {
        font-size: .85rem;
        color: #6c757d;
    }
</style>
@stop

@section('content_header')
<div class="mb-3">
    <h1>
        <i class="fas fa-history text-info"></i>
        Historial de acciones del sistema
    </h1>
    <small class="text-muted">
        Registro completo de operaciones realizadas en la aplicación
    </small>
</div>
@stop

@section('content')
<div class="card card-outline card-info log-card">
    <div class="card-header">
        <h3 class="card-title font-weight-bold">
            <i class="fas fa-clipboard-list"></i>
            Bitácora de eventos
        </h3>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-assets">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Usuario</th>
                        <th>Activo</th>
                        <th>Detalles</th>
                        <th>Fecha</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <td>{{ $log->id }}</td>

                            <td>
                                <span class="badge badge-action">
                                    {{ $log->tipo_registro }}
                                </span>
                            </td>

                            <td>
                                <i class="fas fa-user"></i>
                                {{ $log->usuario_accion_id }}
                            </td>

                            <td>
                                {{ $log->activo_id ?? 'N/A' }}
                            </td>

                            <td>
                                <div class="log-json">
                                    <pre class="mb-0">{{ json_encode($log->detalles_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                </div>
                            </td>

                            <td>
                                <div class="log-date">
                                    <i class="far fa-clock"></i>
                                    {{ $log->created_at->format('d/m/Y H:i') }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                No hay registros en el historial
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop
