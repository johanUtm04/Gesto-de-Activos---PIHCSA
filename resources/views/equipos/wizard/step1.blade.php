@extends('adminlte::page')

@section('title', 'Agregar Equipo Formualario Base)

@section('content_header')
    <h1>Paso 1 — Datos Generales del Equipo</h1>
@stop

@section('content')

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('activos.store.step1') }}" method="POST">
    @csrf

    <div class="card card-primary">
        <div class="card-body">

            <div class="form-group">
                <label>Marca del Equipo</label>
                <input type="text" name="marca_equipo" class="form-control" value="{{ old('marca_equipo') }}" required>
            </div>

            <div class="form-group">
                <label>Tipo de Equipo</label>
                <input type="text" name="tipo_equipo" class="form-control" value="{{ old('tipo_equipo') }}" required>
            </div>

            <div class="form-group">
                <label>Serial</label>
                <input type="text" name="serial" class="form-control" value="{{ old('serial') }}" required>
            </div>

            <div class="form-group">
                <label>Sistema Operativo</label>
                <input type="text" name="sistema_operativo" class="form-control" value="{{ old('sistema_operativo') }}" required>
            </div>

            <div class="form-group">
                <label>Usuario Responsable</label>
                <select name="usuario_id" class="form-control" required>
                    <option value="">Seleccione...</option>
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" {{ old('usuario_id') == $usuario->id ? 'selected' : '' }}>
                            {{ $usuario->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Ubicación</label>
                <select name="ubicacion_id" class="form-control" required>
                    <option value="">Seleccione...</option>
                    @foreach($ubicaciones as $ubicacion)
                        <option value="{{ $ubicacion->id }}" {{ old('ubicacion_id') == $ubicacion->id ? 'selected' : '' }}>
                            {{ $ubicacion->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Valor Inicial</label>
                <input type="number" step="0.01" name="valor_inicial" class="form-control" 
                    value="{{ old('valor_inicial') }}" required>
            </div>

            <div class="form-group">
                <label>Fecha de Adquisición</label>
                <input type="date" name="fecha_adquisicion" class="form-control" 
                    value="{{ old('fecha_adquisicion') }}" required>
            </div>

            <div class="form-group">
                <label>Vida Útil Estimada</label>
                <input type="text" name="vida_util_estimada" class="form-control" 
                    value="{{ old('vida_util_estimada') }}" required>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                Siguiente: Hardware →
            </button>

            <a href="{{ route('activos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </div>
</form>

@stop