@extends('adminlte::page')

@section('title', 'Registro de Nuevo Activo TI')

{{-- -------------------------------------------------------------------------------- --}}
{{-- Estilos personalizados --}}
@section('css')
<style>
    .fieldset-group {
        border: 1px solid #ced4da;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: .25rem;
    }

    .fieldset-group legend {
        width: inherit;
        padding: 0 10px;
        border-bottom: none;
        font-size: 1.1em;
        font-weight: 600;
        color: #007bff; 
    }

    .form-group label {
        font-weight: 500;
        color: #343a40;
    }
</style>
@stop

{{-- -------------------------------------------------------------------------------- --}}
{{-- HEADER PRINCIPAL --}}
@section('content_header')
    <h1 class="font-weight-bold">
        <i class="fas fa-plus-circle text-success"></i> Registrar Nuevo Activo
    </h1>
    <a href="{{ route('equipos.index') }}" class="btn btn-secondary btn-sm mt-2">
        <i class="fas fa-arrow-circle-left"></i> Volver a Inventario
    </a>
@stop

{{-- -------------------------------------------------------------------------------- --}}
{{-- CONTENIDO PRINCIPAL --}}
@section('content')

{{-- Mostrar errores --}}
@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show">
    <strong><i class="fas fa-exclamation-triangle"></i> ¡Ups! Hay algunos errores:</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <ul class="mt-2">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('equipos.store') }}" method="POST">
    @csrf

    <div class="card card-success card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-desktop"></i> **Datos de Identificación del Equipo**
            </h3>
        </div>

        <div class="card-body">
            
            <div class="row">
                
                {{-- COLUMNA 1: IDENTIFICACIÓN Y ESPECIFICACIONES --}}
                <div class="col-md-6">
                    <fieldset class="fieldset-group">
                        <legend><i class="fas fa-info-circle"></i> Base del Activo</legend>

                        {{-- Marca --}}
                        <div class="form-group">
                            <label for="marca_equipo"><i class="fas fa-tag"></i> Marca del Equipo</label>
                            <input 
                                type="text" 
                                name="marca_equipo" 
                                id="marca_equipo"
                                class="form-control"
                                placeholder="Ej. Dell, HP, Lenovo"
                                value="{{ old('marca_equipo') }}" >
                        </div>

                        {{-- Tipo de Equipo --}}
                        <div class="form-group">
                            <label for="tipo_equipo"><i class="fas fa-laptop"></i> Tipo de Equipo</label>
                            <input 
                                type="text" 
                                name="tipo_equipo" 
                                id="tipo_equipo"
                                class="form-control"
                                placeholder="Ej. Laptop, PC, Tablet"
                                value="{{ old('tipo_equipo') }}" 
                                required>
                        </div>

                        {{-- Serial --}}
                        <div class="form-group">
                            <label for="serial"><i class="fas fa-barcode"></i> Serial</label>
                            <input 
                                type="text" 
                                name="serial" 
                                id="serial"
                                class="form-control"
                                placeholder="Número de serie"
                                value="{{ old('serial') }}" 
                                >
                        </div>

                        {{-- Sistema Operativo --}}
                        <div class="form-group">
                            <label for="sistema_operativo"><i class="fab fa-windows"></i> Sistema Operativo *</label>
                            <input 
                                type="text" 
                                name="sistema_operativo" 
                                id="sistema_operativo"
                                class="form-control"
                                placeholder="Ej. Windows 10, macOS Ventura"
                                maxlength="50"
                                value="{{ old('sistema_operativo') }}" 
                                required>
                        </div>
                    </fieldset>
                </div>

                {{-- COLUMNA 2: ASIGNACIÓN Y VALOR --}}
                <div class="col-md-6">
                    <fieldset class="fieldset-group">
                        <legend><i class="fas fa-clipboard-check"></i> Asignación y Valor Contable</legend>

                        {{-- Usuario --}}
                        <div class="form-group">
                            <label for="usuario_id"><i class="fas fa-user-tag"></i> Usuario Responsable *</label>
                            <select name="usuario_id" id="usuario_id" class="form-control select2" required>
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
                            <label for="ubicacion_id"><i class="fas fa-map-marker-alt"></i> Ubicación *</label>
                            <select name="ubicacion_id" id="ubicacion_id" class="form-control select2" required>
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

                        <hr>

                        {{-- Valor Inicial --}}
                        <div class="form-group">
                            <label for="valor_inicial"><i class="fas fa-dollar-sign"></i> Valor Inicial *</label>
                            <input 
                                type="number" 
                                name="valor_inicial" 
                                id="valor_inicial"
                                step="0.01" 
                                class="form-control"
                                placeholder="Ej. 15000.00"
                                value="{{ old('valor_inicial') }}" 
                                >
                        </div>

                        {{-- Fecha de adquisición --}}
                        <div class="form-group">
                            <label for="fecha_adquisicion"><i class="fas fa-calendar-alt"></i> Fecha de Adquisición *</label>
                            <input 
                                type="date" 
                                name="fecha_adquisicion" 
                                id="fecha_adquisicion"
                                class="form-control"
                                value="{{ old('fecha_adquisicion') }}" 
                                required>
                        </div>

                        {{-- Vida Útil --}}
                        <div class="form-group">
                            <label for="vida_util_estimada"><i class="fas fa-hourglass-half"></i> Vida Útil Estimada *</label>
                            <input 
                                type="text" 
                                name="vida_util_estimada" 
                                id="vida_util_estimada"
                                class="form-control"
                                placeholder="Ej. 5 años, 60 meses"
                                value="{{ old('vida_util_estimada') }}" 
                                required>
                        </div>

                    </fieldset>
                </div>

            </div>
            
        </div>

        <div class="card-footer text-right">
            <button type="submit" class="btn btn-success btn-lg">
                <i class="fas fa-save"></i> Guardar y Continuar al Registro de Componentes
            </button>
            <a href="{{ route('equipos.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-times-circle"></i> Cancelar
            </a>
        </div>
    </div>
</form>

@stop

