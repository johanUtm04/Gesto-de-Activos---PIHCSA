@extends('adminlte::page')

@section('title', 'Wizard | Asignar Procesador')

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
        color: #28a745;
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
                <i class="fas fa-microchip text-success"></i> Procesador (CPU)
            </h1>
            <small class="text-muted">
                Paso final · Información del procesador del equipo
            </small>
        </div>

        <a href="{{ route('equipos.wizard-periferico', $uuid) }}"
           class="btn btn-outline-secondary">
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



            <div class="wizard-step active">
            <a href="{{ route('equipos.wizard-discos_duros', $uuid) }}">
                <i class="fas fa-hdd"></i>
                <div>Disco Duro</div>
            </a>
            </div>

            <div class="wizard-step active">
            <a href="{{ route('equipos.wizard-ram', $uuid) }}">
               <i class="fas fa-memory"></i>
                <div>Ram</div>
            </a>
            </div>

            <div class="wizard-step active">
            <a href="{{ route('equipos.wizard-periferico', $uuid) }}">
              <i class="fas fa-mouse"></i> 
                <div>Periferio</div>
            </a>
            </div>

            <div class="wizard-step active">
            <a href="{{ route('equipos.wizard-procesador', $uuid) }}">
              <i class="fas fa-microchip"></i>
                <div>Procesador</div>
            </a>
            </div>

        </div>
    </div>
</div>
@stop

@section('content')

<div class="card card-outline card-success">
    <div class="card-body">

    
        <form action="{{ route('equipos.wizard.saveProcesador', $uuid) }}" method="POST">
            @csrf

            <fieldset class="fieldset-group">

                <legend class="mb-3">
                    <i class="fas fa-microchip"></i> Datos del Procesador
                </legend>

                {{-- Silueta --}}
                <div class="text-center mb-4 text-muted">
                    <i class="fas fa-microchip fa-3x"></i>
                    <div class="small mt-1">Unidad central de procesamiento</div>
                </div>

                {{-- Info activo --}}
                <div class="alert alert-light border mb-4">
                    <strong>Tipo de Activo:</strong>{{ $equipo['tipo_equipo'] ?? '—' }} <br>
                    <strong>Marca:</strong> {{ $equipo['marca_equipo'] ?? '—' }} <br>
                    <strong>Numero de Serie: </strong>{{ $equipo['serial'] ?? '—' }} <br>
                </div>

                <div class="row">
                    {{-- Marca --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="marca">
                                <i class="fas fa-tag"></i> Marca
                            </label>
                            <input type="text"
                                   id="marca"
                                   name="marca"
                                   class="form-control"
                                   value="{{ old('marca', session('wizard_equipo.procesador.marca')) }}"
                                   placeholder="Intel, AMD">
                            @error('marca') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    {{-- Modelo --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="descripcion_tipo">
                                <i class="fas fa-list-alt"></i> Modelo / Descripción
                            </label>
                            <input type="text"
                                   id="descripcion_tipo"
                                   name="descripcion_tipo"
                                   class="form-control"
                                   value="{{ old('descripcion_tipo', session('wizard_equipo.procesador.descripcion_tipo')) }}"
                                   placeholder="Core i7-11700, Ryzen 5 5600X">
                            @error('descripcion_tipo') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>



                    {{-- Frecuencia del Micro --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="frecuenciaMicro">
                                <i class="fas fa-list-alt"></i> Frecuencia del Micro
                            </label>
                            <input type="text"
                                   id="frecuenciaMicro"
                                   name="frecuenciaMicro"
                                   class="form-control"
                                   value="{{ old('frecuenciaMicro', session('wizard_equipo.procesador.frecuenciaMicro')) }}"
                                   placeholder="Ej. 2.6 GHz">
                            @error('frecuenciaMicro') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

            </fieldset>

            {{-- FOOTER FINAL --}}
            <div class="text-right mt-4">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-check-double"></i> Finalizar y ver activo
                </button>

                <!-- <a href="{{ route('equipos.index') }}"
                   class="btn btn-outline-secondary btn-lg">
                    Ir al inventario
                </a> -->
            </div>

        </form>

    </div>
</div>

@stop
