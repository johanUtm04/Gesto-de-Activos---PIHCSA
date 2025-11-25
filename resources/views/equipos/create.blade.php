@extends('adminlte::page')

@section('title', 'Agregar Equipo')

@section('content_header')
    <h1>Agregar Nuevo Equipo</h1>
    <a href="{{ route('equipos.index') }}" class="btn btn-secondary mb-2">Volver</a>
@stop

@section('content')

{{-- Mostrar errores --}}
@if ($errors->any())
<div class="alert alert-danger">
    <strong>Ups! Hay algunos errores:</strong>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('equipos.store') }}" method="POST">
    @csrf

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Datos del Equipo</h3>
        </div>

        <div class="card-body">

            {{-- Marca --}}
            <div class="form-group">
                <label>Marca del Equipo</label>
                <input 
                    type="text" 
                    name="marca_equipo" 
                    class="form-control"
                    placeholder="Ej. Dell, HP, Lenovo"
                    value="{{ old('marca_equipo') }}">
            </div>

            {{-- Tipo --}}
            <div class="form-group">
                <label>Tipo de Equipo</label>
                <input 
                    type="text" 
                    name="tipo_equipo" 
                    class="form-control"
                    placeholder="Ej. Laptop, PC, Tablet"
                    value="{{ old('tipo_equipo') }}" 
                    required>
            </div>

            {{-- Serial --}}
            <div class="form-group">
                <label>Serial</label>
                <input 
                    type="text" 
                    name="serial" 
                    class="form-control"
                    placeholder="Número de serie"
                    value="{{ old('serial') }}" 
                    required>
            </div>

            {{-- Sistema Operativo --}}
            <div class="form-group">
                <label>Sistema Operativo</label>
                <input 
                    type="text" 
                    name="sistema_operativo" 
                    class="form-control"
                    placeholder="Ej. Windows 10"
                    maxlength="50"
                    value="{{ old('sistema_operativo') }}" 
                    required>
            </div>

            {{-- Usuario --}}
            <div class="form-group">
                <label>Usuario Responsable</label>
                <select name="usuario_id" class="form-control" required>
                    <option value="">Seleccione un usuario</option>
                    @foreach($usuarios as $usuario)
                        <option 
                            value="{{ $usuario->id }}" 
                            {{ old('usuario_id') == $usuario->id ? 'selected' : '' }}>
                            {{ $usuario->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Ubicación --}}
            <div class="form-group">
                <label>Ubicación</label>
                <select name="ubicacion_id" class="form-control" required>
                    <option value="">Seleccione una ubicación</option>
                    @foreach($ubicaciones as $ubicacion)
                        <option 
                            value="{{ $ubicacion->id }}" 
                            {{ old('ubicacion_id') == $ubicacion->id ? 'selected' : '' }}>
                            {{ $ubicacion->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Valor Inicial --}}
            <div class="form-group">
                <label>Valor Inicial</label>
                <input 
                    type="number" 
                    name="valor_inicial" 
                    step="0.01" 
                    class="form-control"
                    placeholder="Ej. 15000.00"
                    value="{{ old('valor_inicial') }}" 
                    required>
            </div>

            {{-- Fecha de adquisición --}}
            <div class="form-group">
                <label>Fecha de Adquisición</label>
                <input 
                    type="date" 
                    name="fecha_adquisicion" 
                    class="form-control"
                    value="{{ old('fecha_adquisicion') }}" 
                    required>
            </div>

            {{-- Vida Útil --}}
            <div class="form-group">
                <label>Vida Útil Estimada</label>
                <input 
                    type="text" 
                    name="vida_util_estimada" 
                    class="form-control"
                    placeholder="Ej. 5 años"
                    value="{{ old('vida_util_estimada') }}" 
                    required>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success">Guardar Equipo</button>
            <a href="{{ route('equipos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </div>
</form>

@stop
