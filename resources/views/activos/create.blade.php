@extends('adminlte::page')

@section('title', 'Agregar Equipo')

@section('content_header')
<h1>Agregar Nuevo Equipo</h1>
<a href="{{ route('activos.index') }}" class="btn btn-secondary mb-2">Volver</a>
@stop

@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('activos.store') }}" method="POST">
    @csrf
    <div class="card card-primary">
        <div class="card-body">

            <div class="form-group">
                <label for="marca_equipo">Marca del Equipo</label>
                <input type="text" name="marca_equipo" id="marca_equipo" class="form-control" value="{{ old('marca_equipo') }}">
            </div>

            <div class="form-group">
                <label for="tipo_equipo">Tipo de Equipo</label>
                <input type="text" name="tipo_equipo" id="tipo_equipo" class="form-control" value="{{ old('tipo_equipo') }}" required>
            </div>

            <div class="form-group">
                <label for="serial">Serial</label>
                <input type="text" name="serial" id="serial" class="form-control" value="{{ old('serial') }}" required>
            </div>

            <div class="form-group">
                <label for="sistema_operativo">Sistema Operativo</label>
                <input type="text" name="sistema_operativo" id="sistema_operativo" class="form-control" value="{{ old('sistema_operativo') }}" required maxlength="11">
            </div>

            <div class="form-group">
                <label for="usuario_id">Usuario Asignado</label>
                <select name="usuario_id" id="usuario_id" class="form-control" required>
                    <option value="">Seleccione un usuario</option>
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" {{ old('usuario_id') == $usuario->id ? 'selected' : '' }}>
                            {{ $usuario->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="ubicacion_id">Ubicación</label>
                <select name="ubicacion_id" id="ubicacion_id" class="form-control" required>
                    <option value="">Seleccione una ubicación</option>
                    @foreach($ubicaciones as $ubicacion)
                        <option value="{{ $ubicacion->id }}" {{ old('ubicacion_id') == $ubicacion->id ? 'selected' : '' }}>
                            {{ $ubicacion->nombre ?? 'Sin nombre' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="valor_inicial">Valor Inicial</label>
                <input type="number" step="0.01" name="valor_inicial" id="valor_inicial" class="form-control" value="{{ old('valor_inicial') }}" required>
            </div>

            <div class="form-group">
                <label for="fecha_adquisicion">Fecha de Adquisición</label>
                <input type="date" name="fecha_adquisicion" id="fecha_adquisicion" class="form-control" value="{{ old('fecha_adquisicion') }}" required>
            </div>

            <div class="form-group">
                <label for="vida_util_estimada">Vida Útil Estimada</label>
                <input type="text" name="vida_util_estimada" id="vida_util_estimada" class="form-control" value="{{ old('vida_util_estimada') }}" required>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success">Guardar Equipo</button>
            <a href="{{ route('activos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </div>
</form>

@stop
