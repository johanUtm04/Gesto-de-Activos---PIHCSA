@extends('adminlte::page')

@section('title', 'Wizard | Asignar RAM')

@section('content_header')
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="font-weight-bold">
                <i class="fas fa-magic text-info"></i> Asistente de Configuración (Paso 5)
            </h1>
        </div>
        <div class="col-md-4 text-right">
            {{-- Simulación de Breadcrumb o barra de progreso simple --}}
            <span class="badge badge-success"><i class="fas fa-check"></i> 1. Datos Base</span>
            <span class="badge badge-success"><i class="fas fa-check"></i> 2. Ubicación</span>
            <span class="badge badge-success"><i class="fas fa-check"></i> 3. Monitor</span>
            <span class="badge badge-success"><i class="fas fa-check"></i> 4. Disco Duro</span>
            <span class="badge badge-warning"><i class="fas fa-memory"></i> 5. RAM</span>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid mt-4">

        <div class="card card-warning card-outline">

            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-memory"></i> 
                    Registro de Memoria RAM (Para el activo: <strong>{{ $equipo->serial }}</strong>)
                </h3>
            </div>

            <form action="{{ route('equipos.wizard.saveRam', $equipo) }}" method="POST">
                @csrf
                
                <div class="card-body">

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-1"></i> 
                        Registre la capacidad y especificaciones del módulo RAM.
                    </div>

                    <div class="row">
                        {{-- COLUMNA IZQUIERDA --}}
                        <div class="col-md-6">
                            
                            {{-- Capacidad en GB --}}
                            <div class="form-group">
                                <label for="capacidad_gb"><i class="fas fa-tachometer-alt"></i> Capacidad en GB</label>
                                <input type="text" id="capacidad_gb" class="form-control" name="capacidad_gb" 
                                    value="{{ old('capacidad_gb') }}" placeholder="Ej. 8, 16, 32">
                                @error('capacidad_gb') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            {{-- Clock (Velocidad) --}}
                            <div class="form-group">
                                <label for="clock_mhz"><i class="fas fa-clock"></i> Clock (MHz)</label>
                                {{-- **CORRECCIÓN:** Se asume que el campo debe llamarse 'clock_mhz' para coincidir con el error/validación. --}}
                                <input type="text" id="clock_mhz" class="form-control" name="clock_mhz" 
                                    value="{{ old('clock_mhz') }}" placeholder="Ej. 3200, 2666">
                                @error('clock_mhz') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                        </div>

                        {{-- COLUMNA DERECHA --}}
                        <div class="col-md-6">

                            {{-- Tipo CHZ (Generación) --}}
                            <div class="form-group">
                                <label for="tipo_chz"><i class="fas fa-sitemap"></i> Tipo (Generación)</label>
                                <input type="text" id="tipo_chz" class="form-control" name="tipo_chz" 
                                    value="{{ old('tipo_chz') }}" placeholder="Ej. DDR4, DDR5">
                                @error('tipo_chz') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>


                        </div>

                    </div>
                </div>

                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-chevron-circle-right"></i> Guardar RAM y Continuar
                    </button>
                
                    <a href="{{ route('equipos.wizard-periferico', $equipo) }}" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-forward"></i> Omitir este paso
                    </a>

                </div>
            </form>
        </div>
    </div>
@endsection