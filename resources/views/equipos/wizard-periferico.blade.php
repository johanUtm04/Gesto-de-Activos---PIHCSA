@extends('adminlte::page')

@section('title', 'Wizard | Asignar Periférico')

@section('content_header')
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="font-weight-bold">
                <i class="fas fa-magic text-info"></i> Asistente de Configuración (Paso 6)
            </h1>
        </div>
        <div class="col-md-4 text-right">
            {{-- Simulación de Breadcrumb o barra de progreso simple --}}
            <span class="badge badge-success"><i class="fas fa-check"></i> 1-5. Base / Comp.</span>
            <span class="badge badge-info"><i class="fas fa-keyboard"></i> 6. Periférico</span>
            <span class="badge badge-secondary">7. Finalizar</span>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid mt-4">

        <div class="card card-info card-outline">

            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-keyboard"></i> 
                    Registro de Periférico (Para el activo: <strong>{{ $equipo->serial }}</strong>)
                </h3>
            </div>

            <form action="{{ route('equipos.wizard.savePeriferico', $equipo) }}" method="POST">
                @csrf
                
                <div class="card-body">

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-1"></i> 
                        Registre un periférico asociado al equipo (ej. Teclado, Ratón, Webcam). Puede registrar componentes adicionales en la edición avanzada.
                    </div>

                    <div class="row">
                        {{-- COLUMNA IZQUIERDA --}}
                        <div class="col-md-6">
                            
                            {{-- Tipo --}}
                            <div class="form-group">
                                <label for="tipo"><i class="fas fa-mouse-pointer"></i> Tipo de Periférico</label>
                                <input type="text" id="tipo" class="form-control" name="tipo" 
                                    value="{{ old('tipo') }}" placeholder="Ej. Teclado, Ratón, Webcam">
                                @error('tipo') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            {{-- Marca --}}
                            <div class="form-group">
                                <label for="marca"><i class="fas fa-tag"></i> Marca</label>
                                <input type="text" id="marca" class="form-control" name="marca" 
                                    value="{{ old('marca') }}" placeholder="Ej. Logitech, Razer">
                                @error('marca') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                        </div>

                        {{-- COLUMNA DERECHA --}}
                        <div class="col-md-6">

                            {{-- Serial --}}
                            <div class="form-group">
                                <label for="serial"><i class="fas fa-barcode"></i> Serial</label>
                                <input type="text" id="serial" class="form-control" name="serial" 
                                    value="{{ old('serial') }}" placeholder="Número de serie único">
                                @error('serial') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            {{-- Interface --}}
                            <div class="form-group">
                                <label for="interface"><i class="fas fa-plug"></i> Interfaz de Conexión</label>
                                <input type="text" id="interface" class="form-control" name="interface" 
                                    value="{{ old('interface') }}" placeholder="Ej. USB, Bluetooth, PS/2">
                                @error('interface') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-check-circle"></i> Guardar y Finalizar
                    </button>
                    

                </div>
            </form>
        </div>
    </div>
@endsection