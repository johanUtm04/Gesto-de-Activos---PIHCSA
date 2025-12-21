@extends('adminlte::page')

@section('title', 'Wizard | Asignar RAM')


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
                <i class="fas fa-memory text-warning"></i> Memoria RAM
            </h1>
            <small class="text-muted">
                Paso 5 de 6 · Registro de memoria del activo
            </small>
        </div>

        <a href="{{ route('equipos.wizard-discos_duros', $uuid) }}" class="btn btn-outline-secondary">
            <i class="fas fa-chevron-left"></i> Anterior
        </a>
    </div>
</div>

{{-- WIZARD --}}
<div class="card mb-3">
    <div class="card-body p-3">
        <div class="d-flex justify-content-between text-center wizard-steps">

            <div class="wizard-step completed">
                <i class="fas fa-desktop"></i>
                <div>Activo</div>
            </div>

            <div class="wizard-step completed">
                <i class="fas fa-map-marker-alt"></i>
                <div>Ubicación</div>
            </div>

            <div class="wizard-step completed">
                <i class="fas fa-tv"></i>
                <div>Monitor</div>
            </div>

            <div class="wizard-step completed">
                <i class="fas fa-hdd"></i>
                <div>Disco</div>
            </div>

            <div class="wizard-step active">
                <i class="fas fa-memory"></i>
                <div>RAM</div>
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

        <form action="{{ route('equipos.wizard.saveRam', $uuid) }}" method="POST">
           
            @csrf

            <fieldset class="fieldset-group">

                <legend class="mb-3">
                    <i class="fas fa-memory"></i> Datos de la Memoria RAM
                </legend>

                {{-- Silueta --}}
                <div class="text-center mb-4 text-muted">
                    <i class="fas fa-microchip fa-3x"></i>
                    <div class="small mt-1">Módulo de memoria</div>
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
                            <label for="capacidad_gb">
                                <i class="fas fa-tachometer-alt"></i> Capacidad (GB)
                            </label>
                            <input type="text"
                                   id="capacidad_gb"
                                   name="capacidad_gb"
                                   class="form-control"
                                   value="{{ old('capacidad_gb', session('wizard_equipo.ram.capacidad_gb')) }}"
                                   placeholder="Ej. 8, 16, 32">
                            @error('capacidad_gb') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label for="clock_mhz">
                                <i class="fas fa-clock"></i> Velocidad (MHz)
                            </label>
                            <input type="text"
                                   id="clock_mhz"
                                   name="clock_mhz"
                                   class="form-control"
                                   value="{{ old('clock_mhz', session('wizard_equipo.ram.clock_mhz')) }}"
                                   placeholder="Ej. 2666, 3200">
                            @error('clock_mhz') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                    </div>

                    {{-- COLUMNA DERECHA --}}
                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="tipo_chz">
                                <i class="fas fa-sitemap"></i> Tipo / Generación
                            </label>
                            <input type="text"
                                   id="tipo_chz"
                                   name="tipo_chz"
                                   class="form-control"
                                   value="{{ old('tipo_chz', session('wizard_equipo.ram.tipo_chz')) }}"
                                   placeholder="Ej. DDR4, DDR5">
                            @error('tipo_chz') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                    </div>
                </div>

            </fieldset>

            {{-- FOOTER --}}
            <div class="text-right mt-4">
                <button type="submit" class="btn btn-warning btn-lg">
                    <i class="fas fa-arrow-right"></i> Guardar y continuar
                </button>

                <a href="{{ route('equipos.wizard-periferico', $uuid) }}"
                   class="btn btn-outline-secondary btn-lg">
                    Omitir este paso
                </a>
            </div>

        </form>

    </div>
</div>

@stop
