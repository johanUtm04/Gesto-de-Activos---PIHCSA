@extends('adminlte::page')

@section('title', 'Wizard | Asignar Periférico')

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
        color: #17a2b8;
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
                <i class="fas fa-keyboard text-info"></i> Periféricos
            </h1>
            <small class="text-muted">
                Paso 6 de 6 · Accesorios asociados al activo
            </small>
        </div>

        <a href="{{ route('equipos.wizard-ram', $uuid) }}" class="btn btn-outline-secondary">
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

            <div class="wizard-step completed">
                <i class="fas fa-memory"></i>
                <div>RAM</div>
            </div>

            <div class="wizard-step active">
                <i class="fas fa-keyboard"></i>
                <div>Periféricos</div>
            </div>

        </div>
    </div>
</div>
@stop

@section('content')

<div class="card card-outline card-info">
    <div class="card-body">
        

        <form action="{{ route('equipos.wizard.savePeriferico', $uuid) }}" method="POST">
            @csrf

            <fieldset class="fieldset-group">

                <legend class="mb-3">
                    <i class="fas fa-keyboard"></i> Datos del Periférico
                </legend>

                {{-- Silueta --}}
                <div class="text-center mb-4 text-muted">
                    <i class="fas fa-mouse fa-3x"></i>
                    <div class="small mt-1">Accesorio externo</div>
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
                            <label for="tipo">
                                <i class="fas fa-mouse-pointer"></i> Tipo
                            </label>
                            <input type="text"
                                   id="tipo"
                                   name="tipo"
                                   class="form-control"
                                   value="{{ old('tipo', session('wizard_equipo.periferico.tipo')) }}"
                                   placeholder="Teclado, Mouse, Webcam">
                            @error('tipo') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label for="marca">
                                <i class="fas fa-tag"></i> Marca
                            </label>
                            <input type="text"
                                   id="marca"
                                   name="marca"
                                   class="form-control"
                                   value="{{ old('marca', session('wizard_equipo.periferico.marca')) }}"
                                   placeholder="Logitech, HP, Dell">
                            @error('marca') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                    </div>

                    {{-- COLUMNA DERECHA --}}
                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="serial">
                                <i class="fas fa-barcode"></i> Serial
                            </label>
                            <input type="text"
                                   id="serial"
                                   name="serial"
                                   class="form-control"
                                   value="{{ old('serial', session('wizard_equipo.periferico.serial')) }}"
                                   placeholder="Número de serie">
                            @error('serial') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label for="interface">
                                <i class="fas fa-plug"></i> Interfaz
                            </label>
                            <input type="text"
                                   id="interface"
                                   name="interface"
                                   class="form-control"
                                   value="{{ old('interface', session('wizard_equipo.periferico.interface')) }}"
                                   placeholder="USB, Bluetooth">
                            @error('interface') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                    </div>
                </div>

            </fieldset>

            {{-- FOOTER --}}
            <div class="text-right mt-4">
                <button type="submit" class="btn btn-warning btn-lg">
            <i class="fas fa-arrow-right"></i> Guardar y continuar
                </button>

                <a href="{{ route('equipos.wizard-procesador', $uuid) }}"
                   class="btn btn-outline-secondary btn-lg">
                    Omitir este paso
                </a>

            </div>

        </form>

    </div>
</div>

@stop
