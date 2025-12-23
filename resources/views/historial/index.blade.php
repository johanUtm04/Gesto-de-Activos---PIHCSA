@extends('adminlte::page')

@section('title', 'Historial de Auditoría')

@section('content_header')
    <h1>Historial de Auditoría</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo de Registro</th>
                    <th>Usuario</th>
                    <th>Activo</th>
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
    </div>
</div>
@stop
