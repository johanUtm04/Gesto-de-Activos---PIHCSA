@extends('adminlte::page')

@section('title', 'Wizard | Asignar Disco Duro')

{{-- ================================================================================= --}}
{{-- ESTILOS --}}
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
                <i class="fas fa-hdd text-info"></i> Disco Duro
            </h1>
            <small class="text-muted">
                Paso 4 de 5 · Registro de almacenamiento del activo
            </small>
        </div>

        <a href="{{ route('equipos.wizard-monitores', $uuid) }}" class="btn btn-outline-secondary">
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

            <div class="wizard-step active">
                <i class="fas fa-hdd"></i>
                <div>Disco</div>
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

<div class="card card-outline card-info">
    <div class="card-body">

        <form action="{{ route('equipos.wizard.saveDiscoduro', $uuid) }}" method="POST">
            @csrf

            <fieldset class="fieldset-group">

                <legend class="mb-3">
                    <i class="fas fa-hdd"></i> Datos del Almacenamiento
                </legend>

                {{-- Silueta --}}
                <div class="text-center mb-4 text-muted">
                    <i class="fas fa-database fa-3x"></i>
                    <div class="small mt-1">Disco asociado</div>
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
                            <label for="capacidad">
                                <i class="fas fa-archive"></i> Capacidad
                            </label>
                            <input type="text"
                                   id="capacidad"
                                   name="capacidad"
                                   class="form-control"
                                   value="{{ old('capacidad', session('wizard_equipo.disco_duro.capacidad')) }}"
                                   placeholder="Ej. 256GB, 512GB, 1TB">
                            @error('capacidad') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label for="tipo_hdd_ssd">
                                <i class="fas fa-memory"></i> Tipo
                            </label>
                            <input type="text"
                                   id="tipo_hdd_ssd"
                                   name="tipo_hdd_ssd"
                                   class="form-control"
                                   value="{{ old('tipo_hdd_ssd', session('wizard_equipo.disco_duro.tipo_hdd_ssd') ) }}"
                                   placeholder="SSD, NVMe, HDD">
                            @error('tipo_hdd_ssd') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                    </div>

                    {{-- COLUMNA DERECHA --}}
                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="interface">
                                <i class="fas fa-plug"></i> Interfaz
                            </label>
                            <input type="text"
                                   id="interface"
                                   name="interface"
                                   class="form-control"
                                   value="{{ old('interface', session('wizard_equipo.disco_duro.interface')) }}"
                                   placeholder="SATA III, PCIe, M.2">
                            @error('interface') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                    </div>
                </div>

            </fieldset>

            {{-- FOOTER --}}
            <div class="text-right mt-4">
                <button type="submit" class="btn btn-info btn-lg">
                    <i class="fas fa-arrow-right"></i> Guardar y continuar
                </button>

                <a href="{{ route('equipos.wizard-ram', $uuid) }}"
                   class="btn btn-outline-secondary btn-lg">
                    Omitir este paso
                </a>
            </div>

        </form>

    </div>
</div>

@stop
