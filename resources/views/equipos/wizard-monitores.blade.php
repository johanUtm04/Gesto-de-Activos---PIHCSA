@extends('adminlte::page')

@section('title', 'Wizard | Asignar Monitor')

@section('content_header')
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="font-weight-bold">
                <i class="fas fa-magic text-info"></i> Asistente de Configuración (Paso 3)
            </h1>
        </div>
        <div class="col-md-4 text-right">
            {{-- Simulación de Breadcrumb o barra de progreso simple --}}
            <span class="badge badge-success"><i class="fas fa-check"></i> 1. Datos Base</span>
            <span class="badge badge-success"><i class="fas fa-check"></i> 2. Ubicación</span>
            <span class="badge badge-primary"><i class="fas fa-tv"></i> 3. Monitores</span>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid mt-4">

        <div class="card card-warning card-outline">

            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-tv"></i> 
                    Registro de Monitor (Para el activo: <strong>{{ $equipo->serial }}</strong>)
                </h3>
            </div>

            <form action="{{ route('equipos.wizard.saveMonitor', $equipo) }}" method="POST">
                @csrf
                
                <div class="card-body">

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-1"></i> 
                        Registre un monitor principal para el equipo. Puede agregar monitores adicionales o componentes en la edición avanzada, o saltar este paso.
                    </div>

                    <div class="row">
                        {{-- COLUMNA IZQUIERDA --}}
                        <div class="col-md-6">
                            
                            {{-- Marca --}}
                            <div class="form-group">
                                <label for="marca"><i class="fas fa-tag"></i> Marca</label>
                                <input type="text" id="marca" class="form-control" name="marca" 
                                    value="{{ old('marca') }}" placeholder="Ej. Samsung, LG">
                                @error('marca') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            {{-- Serial --}}
                            <div class="form-group">
                                <label for="serial"><i class="fas fa-barcode"></i> Serial</label>
                                <input type="text" id="serial" class="form-control" name="serial" 
                                value="{{ old('serial') }}" placeholder="Ej. ABC12345DEF6789">
                                @error('serial') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                        </div>

                        {{-- COLUMNA DERECHA --}}
                        <div class="col-md-6">

                            {{-- Escala en Pulgadas --}}
                            <div class="form-group">
                                <label for="escala_pulgadas"><i class="fas fa-ruler-combined"></i> Escala en Pulgadas</label>
                                <input type="text" id="escala_pulgadas" class="form-control" name="escala_pulgadas" 
                                    value="{{ old('escala_pulgadas') }}" placeholder="Ej. 24, 32">
                                @error('escala_pulgadas') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            {{-- Interface --}}
                            <div class="form-group">
                                <label for="interface"><i class="fas fa-plug"></i> Interfaz de Conexión</label>
                                <input type="text" id="interface" class="form-control" name="interface" 
                                    value="{{ old('interface') }}" placeholder="Ej. HDMI, DisplayPort, VGA">
                                @error('interface') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-save"></i> Guardar Monitor y Continuar
                    </button>

                    <a href="{{ route('equipos.wizard-discos_duros', $equipo) }}" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-forward"></i> Omitir este paso
                    </a>

                </div>
            </form>

        </div>
    </div>
@endsection