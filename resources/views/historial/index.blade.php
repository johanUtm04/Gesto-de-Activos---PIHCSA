@extends('adminlte::page')

@section('title', 'Historial')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="mb-0">
            <i class="fas fa-clocks text-info"></i> Historial de Acciones de la aplicacion web
        </h1>
    </div>
</div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
             <div class="table-responsive">
                <table class="table table-bordered table-hover table-assets">
            <thead>
                <tr>
                    <th>ID</th>
                    <th><i class="fas fa-cogs"></i>Tipo de Registro</th>
                    <th><i class="fas fa-user-tag"></i>Usuario</th>
                    <th><i class="fas fa-tag"></i> Id del Activo</th>
                    <th>Detalles</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->tipo_registro }}</td>
                        <td>{{ $log->usuario_accion_id }}</td>
                        <td>{{ $log->activo_id ?? 'N/A' }}</td>
                        <td>
                            <pre>{{ json_encode($log->detalles_json, JSON_PRETTY_PRINT) }}</pre>
                        </td>
                        <td>{{ $log->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div> {{-- /table-responsive --}}
    </div> {{-- /card-body --}}
</div> {{-- /card --}}
@stop
