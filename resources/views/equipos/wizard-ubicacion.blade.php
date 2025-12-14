@extends('adminlte::page')

@section('title', 'Wizard | Asignar Ubicación')

@section('content_header')
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="font-weight-bold">
                <i class="fas fa-magic text-info"></i> Asistente de Configuración (Paso 2)
            </h1>
        </div>
        <div class="col-md-4 text-right">
            {{-- Simulación de Breadcrumb o barra de progreso simple --}}
            <span class="badge badge-success"><i class="fas fa-check"></i> 1. Datos Base</span>
            <span class="badge badge-primary"><i class="fas fa-map-marker-alt"></i> 2. Ubicación</span>
            <span class="badge badge-secondary">3. Componentes</span>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid mt-4">
        
        <div class="card card-primary card-outline">
            
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-map-signs"></i> 
                    Asignar Ubicación para el Activo: <strong>{{ $equipo->serial }}</strong>
                </h3>
            </div>

            <form action="{{ route('equipos.wizard.saveUbicacion', $equipo) }}" method="POST">
                @csrf
                
                <div class="card-body">
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-1"></i> 
                        Seleccione el lugar físico donde se instalará este equipo.
                    </div>

                    {{-- Ubicación --}}
                    <div class="form-group">
                        <label for="ubicacion_id"><i class="fas fa-warehouse"></i> Ubicación Actual</label>
                        <select name="ubicacion_id" id="ubicacion_id" class="form-control select2" required>
                            <option value="">Seleccione una ubicación...</option>
                            @foreach(\App\Models\Ubicacion::all() as $ubicacion)
                                <option value="{{ $ubicacion->id }}">{{ $ubicacion->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-chevron-circle-right"></i> Guardar y Continuar al Paso 3
                    </button>
                    {{-- Si hay una ruta de retroceso, puedes poner un botón aquí --}}
                </div>

            </form>
        </div>
    </div>
@endsection

@section('js')
    {{-- Script para inicializar Select2 --}}
    <script>
        $(document).ready(function() {
            // Inicializa Select2 en el dropdown de Ubicación para búsqueda y mejor UX
            $('#ubicacion_id').select2({
                theme: 'bootstrap4',
                placeholder: 'Buscar o seleccionar ubicación...',
                allowClear: true
            });
        });
    </script>
@stop