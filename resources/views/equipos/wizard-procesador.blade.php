@extends('adminlte::page')

@section('title', 'Wizard | Asignar Procesador')

@section('content_header')
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="font-weight-bold">
                <i class="fas fa-magic text-info"></i> Asistente de Configuración (Paso 7 - Final)
            </h1>
        </div>
        <div class="col-md-4 text-right">
            {{-- Simulación de Breadcrumb o barra de progreso simple --}}
            <span class="badge badge-success"><i class="fas fa-check"></i> 1-6. Componentes</span>
            <span class="badge badge-success"><i class="fas fa-microchip"></i> 7. Procesador</span>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid mt-4">

        <div class="card card-success card-outline">

            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-microchip"></i> 
                    Registro de Procesador (CPU) (Para el activo: <strong>{{ $equipo->serial }}</strong>)
                </h3>
            </div>

            <form action="{{ route('equipos.wizard.saveProcesador', $equipo) }}" method="POST">
                @csrf
                
                <div class="card-body">

                    <div class="alert alert-success">
                        <i class="fas fa-info-circle mr-1"></i> 
                        Este es el último paso. Registre el componente principal del equipo, el Procesador. 
                    </div>

                    <div class="row">
                        {{-- COLUMNA IZQUIERDA --}}
                        <div class="col-md-6">
                            
                            {{-- Marca --}}
                            <div class="form-group">
                                <label for="marca"><i class="fas fa-tag"></i> Marca</label>
                                <input type="text" id="marca" class="form-control" name="marca" 
                                    value="{{ old('marca') }}" placeholder="Ej. Intel, AMD">
                                @error('marca') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- COLUMNA DERECHA --}}
                        <div class="col-md-6">
                            
                            {{-- Tipo (Descripción) --}}
                            <div class="form-group">
                                <label for="descripcion_tipo"><i class="fas fa-list-alt"></i> Tipo (Descripción/Modelo)</label>
                                <input type="text" id="descripcion_tipo" class="form-control" name="descripcion_tipo" 
                                    value="{{ old('descripcion_tipo') }}" placeholder="Ej. Core i7-11700, Ryzen 5 5600X">
                                @error('descripcion_tipo') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-check-double"></i> Finalizar Asistente y Ver Activo
                    </button>

                </div>
            </form>
        </div>
    </div>
@endsection