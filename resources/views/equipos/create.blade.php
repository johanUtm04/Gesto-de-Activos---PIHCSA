@extends('adminlte::page')

@section('title', 'Registrar Nuevo Activo TI')

{{-- ================================================================================= --}}
{{-- ESTILOS --}}
@section('css')
<style>
    /* Wizard */
    .wizard-steps {
        font-size: 14px;
    }

    .wizard-step {
        color: #adb5bd;
    }

    .wizard-step i {
        font-size: 22px;
        margin-bottom: 4px;
        display: block;
    }

    .wizard-step.active {
        color: #28a745;
        font-weight: 600;
    }

    .fieldset-group {
        border: 1px solid #ced4da;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: .25rem;
        background-color: #ffffff;
    }

    .fieldset-group legend {
        width: inherit;
        padding: 0 10px;
        border-bottom: none;
        font-size: 1.1em;
        font-weight: 600;
        color: #007bff;
    }

    .fieldset-group i.fa-3x {
        opacity: 0.25;
    }

    .form-group label {
        font-weight: 500;
    }
</style>
@stop

@section('content_header')
<div class="mb-3">
    <h1 class="font-weight-bold mb-1">
        <i class="fas fa-plus-circle text-success"></i> Registrar Nuevo Activo
    </h1>
    <a href="{{ route('equipos.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Volver al inventario
    </a>
</div>

{{-- WIZARD --}}
<div class="card mb-3">
    <div class="card-body p-3">
        <div class="d-flex justify-content-between text-center wizard-steps">
            <div class="wizard-step active">
                <i class="fas fa-desktop"></i>
                <div>Activo</div>
            </div>
            <div class="wizard-step">
                <i class="fas fa-user-check"></i>
                <div>Asignación</div>
            </div>
            <div class="wizard-step">
                <i class="fas fa-microchip"></i>
                <div>Componentes</div>
            </div>
            <div class="wizard-step">
                <i class="fas fa-flag-checkered"></i>
                <div>Final</div>
            </div>
        </div>
    </div>
</div>
@stop

@section('content')

{{-- ERRORES --}}
@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show">
    <strong><i class="fas fa-exclamation-triangle"></i> Revisa los datos</strong>
    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
    <ul class="mt-2 mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('equipos.store') }}" method="POST">
@csrf

<div class="card card-outline card-success">
    <div class="card-body">

        <div class="row">

            {{-- COLUMNA IZQUIERDA --}}
            <div class="col-md-6">
                <fieldset class="fieldset-group">
                    <legend><i class="fas fa-info-circle"></i> Base del Activo</legend>

                    {{-- Silueta --}}
                    <div class="text-center mb-3 text-muted">
                        <i class="fas fa-laptop fa-3x"></i>
                        <div class="small mt-1">Información del equipo</div>
                    </div>

                    <div class="form-group">
                        <label>Marca</label>
                        <input type="text" name="marca_equipo" class="form-control"
                               placeholder="Dell, HP, Lenovo"
                               value="{{ old('marca_equipo') }}">
                    </div>

                    <div class="form-group">
                        <label>Tipo de equipo *</label>
                        <input type="text" name="tipo_equipo" class="form-control"
                               placeholder="Laptop, PC, Tablet"
                               value="{{ old('tipo_equipo') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Serial</label>
                        <input type="text" name="serial" class="form-control"
                               placeholder="Número de serie"
                               value="{{ old('serial, session(wizard_equipo.equipo.serial')}}">
                        <small class="form-text text-muted">
                            Identificador único del activo
                        </small>
                    </div>

                    <div class="form-group">
                        <label>Sistema Operativo *</label>
                        <input type="text" name="sistema_operativo" class="form-control"
                               placeholder="Windows 10, macOS, Linux"
                               value="{{ old('sistema_operativo') }}" required>
                    </div>
                </fieldset>
            </div>

            {{-- ========================================================= --}}
            {{-- COLUMNA DERECHA --}}
            <div class="col-md-6">
                <fieldset class="fieldset-group">
                    <legend><i class="fas fa-clipboard-check"></i> Asignación y Valor</legend>

                    {{-- Silueta --}}
                    <div class="text-center mb-3 text-muted">
                        <i class="fas fa-user-cog fa-3x"></i>
                        <div class="small mt-1">Responsable y valor</div>
                    </div>

                    <div class="form-group">
                        <label>Usuario responsable *</label>
                        <select name="usuario_id" class="form-control select2" required>
                            <option value="">Seleccione un usuario</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}"
                                    {{ old('usuario_id') == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <hr>

                    <div class="form-group">
                        <label>Valor inicial *</label>
                        <input type="number" name="valor_inicial" class="form-control"
                               step="0.01" placeholder="15000.00"
                               value="{{ old('valor_inicial') }}">
                    </div>

                    <div class="form-group">
                        <label>Fecha de adquisición *</label>
                        <input type="date" name="fecha_adquisicion" class="form-control"
                               value="{{ old('fecha_adquisicion') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Vida útil estimada *</label>
                        <input type="text" name="vida_util_estimada" class="form-control"
                               placeholder="5 años / 60 meses"
                               value="{{ old('vida_util_estimada') }}" required>
                    </div>
                </fieldset>
            </div>

        </div>
    </div>

    {{-- FOOTER --}}
    <div class="card-footer text-right">
        <button type="submit" class="btn btn-success btn-lg">
            <i class="fas fa-arrow-right"></i> Guardar y continuar
        </button>
        
        <a href="{{ route('equipos.index') }}" class="btn btn-secondary btn-lg">
            Cancelar
        </a>
    </div>
</div>
</form>

@stop
