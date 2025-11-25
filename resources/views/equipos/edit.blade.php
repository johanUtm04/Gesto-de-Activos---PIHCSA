@extends('adminlte::page')

@section('title', 'Editar Equipo')

@section('content_header')
<h1>Editar Equipo</h1>
<a href="{{ route('equipos.index') }}" class="btn btn-secondary mb-2">Volver</a>
@stop

@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        hay errores
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('equipos.update', $equipo) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="card card-primary">
        <div class="card-body">

            <div class="form-group">
                <label>Marca del Equipo</label>
                <input type="text" name="marca_equipo" class="form-control" value="{{ old('marca_equipo', $equipo->marca_equipo) }}">
            </div>

            <div class="form-group">
                <label>Tipo de Equipo</label>
                <input type="text" name="tipo_equipo" class="form-control" value="{{ old('tipo_equipo', $equipo->tipo_equipo) }}" required>
            </div>

            <div class="form-group">
                <label>Serial</label>
                <input type="text" name="serial" class="form-control" value="{{ old('serial', $equipo->serial) }}" required>
            </div>

            <div class="form-group">
                <label>Sistema Operativo</label>
                <input type="text" name="sistema_operativo" class="form-control" value="{{ old('sistema_operativo', $equipo->sistema_operativo) }}" maxlength="11" required>
            </div>

            <div class="form-group">
                <label>Usuario Responsable</label>
                <select name="usuario_id" class="form-control" required>
                    <option value="">Seleccione un usuario</option>
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" {{ old('usuario_id', $equipo->usuario_id) == $usuario->id ? 'selected' : '' }}>
                            {{ $usuario->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Ubicación</label>
                <select name="ubicacion_id" class="form-control" required>
                    <option value="">Seleccione una ubicación</option>
                    @foreach($ubicaciones as $ubicacion)
                        <option value="{{ $ubicacion->id }}" {{ old('ubicacion_id', $equipo->ubicacion_id) == $ubicacion->id ? 'selected' : '' }}>
                            {{ $ubicacion->nombre ?? '-' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Valor Inicial</label>
                <input type="number" name="valor_inicial" step="0.01" class="form-control" value="{{ old('valor_inicial', $equipo->valor_inicial) }}" required>
            </div>

            <div class="form-group">
                <label>Fecha de Adquisición</label>
                <input type="date" name="fecha_adquisicion" class="form-control" value="{{ old('fecha_adquisicion', $equipo->fecha_adquisicion) }}" required>
            </div>

            <div class="form-group">
                <label>Vida Útil Estimada</label>
                <input type="text" name="vida_util_estimada" class="form-control" value="{{ old('vida_util_estimada', $equipo->vida_util_estimada) }}" required>
            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Actualizar Equipo</button>
            <a href="{{ route('equipos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </div>
</form>
@stop
