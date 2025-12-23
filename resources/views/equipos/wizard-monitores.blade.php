
@extends('adminlte::page')

@section('title', 'Wizard | Asignar Monitor')

@section('css')
<style>
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
        color: #ffc107;
        font-weight: 600;
    }

    .wizard-step.completed {
        color: #28a745;
    }

    .fieldset-group {
        border: 1px solid #ced4da;
        padding: 25px;
        border-radius: .25rem;
        background-color: #ffffff;
    }

    .fieldset-group i.fa-3x {
        opacity: 0.25;
    }
</style>
@stop

@section('content_header')
<div class="mb-3">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="font-weight-bold mb-1">
                <i class="fas fa-tv text-warning"></i> Monitor
            </h1>
            <small class="text-muted">
                Paso 3 de 4 · Registro de monitor asociado al activo
            </small>
        </div>

        <a href="{{ route('equipos.wizard-ubicacion', $uuid) }}" class="btn btn-outline-secondary">
            <i class="fas fa-chevron-left"></i> Anterior
        </a>
    </div>
</div>

{{-- WIZARD SIMULACION --}}
<div class="card mb-3">
    <div class="card-body p-3">
        <div class="d-flex justify-content-between text-center wizard-steps">

            <div class="wizard-step completed">
                <a href="{{ route('equipos.wizard.create') }}">
                    <i class="fas fa-desktop"></i>
                    <div>Activo</div>
                </a>
            </div>

            <div class="wizard-step completed">
            <a href="{{ route('equipos.wizard-ubicacion', $uuid) }}">
                <i class="fas fa-map-marker-alt"></i>
                <div>Ubicacion</div>
            </a>
            </div>

            <div class="wizard-step active">
            <a href="{{ route('equipos.wizard-monitores', $uuid) }}">
                <i class="fas fa-tv"></i>
                <div>Monitor</div>
            </a>
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

<div class="card card-outline card-warning">
    <div class="card-body">

        <form action="{{ route('equipos.wizard.saveMonitor', $uuid) }}" method="POST">
            @csrf

            <fieldset class="fieldset-group">

                <legend class="mb-3">
                    <i class="fas fa-tv"></i> Datos del Monitor
                </legend>

                {{-- Silueta --}}
                <div class="text-center mb-4 text-muted">
                    <i class="fas fa-desktop fa-3x"></i>
                    <div class="small mt-1">Monitor asociado</div>
                </div>

                {{-- Info activo --}}
                <div class="alert alert-light border mb-4">
                    <strong>Tipo de Activo:</strong>{{ $equipo['tipo_equipo'] ?? '—' }} <br>
                    <strong>Marca:</strong> {{ $equipo['marca_equipo'] ?? '—' }} <br>
                    <strong>Numero de Serie: </strong>{{ $equipo['serial'] ?? '—' }} <br>
                </div>

                <div class="row">
                    {{-- COLUMNA IZQUIERDA --}}
                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="marca">
                                <i class="fas fa-tag"></i> Marca
                            </label>
                            <input type="text"
                                   id="marca"
                                   name="marca"
                                   class="form-control"
                                    value="{{ old('marca', session('wizard_equipo.monitor.marca')) }}"
                                   placeholder="Ej. Samsung, LG">
                            @error('marca') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label for="serial">
                                <i class="fas fa-barcode"></i> Serial
                            </label>
                            <input type="text"
                                   id="serial"
                                   name="serial"
                                   class="form-control"
                                   value="{{ old('serial', session('wizard_equipo.monitor.serial')) }}"
                                   placeholder="Ej. ABC12345">
                            @error('serial') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                    </div>

                    {{-- COLUMNA DERECHA --}}
                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="escala_pulgadas">
                                <i class="fas fa-ruler-combined"></i> Tamaño (pulgadas)
                            </label>
                            <input type="text"
                                   id="escala_pulgadas"
                                   name="escala_pulgadas"
                                   class="form-control"
                                   value="{{ old('escala_pulgadas', session('wizard_equipo.monitor.escala_pulgadas')) }}"
                                   placeholder="Ej. 24, 27, 32">
                            @error('escala_pulgadas') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label for="interface">
                                <i class="fas fa-plug"></i> Interfaz
                            </label>
                            <input type="text"
                                   id="interface"
                                   name="interface"
                                   class="form-control"
                                   value="{{ old('interface', session('wizard_equipo.monitor.interface')) }}"
                                   placeholder="HDMI, DisplayPort, VGA">
                            @error('interface') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                    </div>
                </div>

            </fieldset>

            {{-- FOOTER --}}
            <div class="text-right mt-4">
                <button type="submit" class="btn btn-warning btn-lg">
                    <i class="fas fa-arrow-right"></i> Continuar
                </button>

                <!-- <a href="{{ route('equipos.wizard-discos_duros', $uuid) }}"
                   class="btn btn-outline-secondary btn-lg">
                    Omitir TODO este paso
                </a> -->
            </div>

        </form>

    </div>
</div>

@stop
