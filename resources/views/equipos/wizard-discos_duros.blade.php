@extends('adminlte::page')

@section('title', 'Wizard | Asignar Disco Duro')

@section('content_header')
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="font-weight-bold">
                <i class="fas fa-magic text-info"></i> Asistente de Configuración (Paso 4)
            </h1>
        </div>
        <div class="col-md-4 text-right">
            {{-- Simulación de Breadcrumb o barra de progreso simple --}}
            <span class="badge badge-success"><i class="fas fa-check"></i> 1. Datos Base</span>
            <span class="badge badge-success"><i class="fas fa-check"></i> 2. Ubicación</span>
            <span class="badge badge-success"><i class="fas fa-check"></i> 3. Monitores</span>
            <span class="badge badge-primary"><i class="fas fa-hdd"></i> 4. Disco Duro</span>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid mt-4">

        <div class="card card-primary card-outline">

            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-hdd"></i> 
                    Registro de Almacenamiento (Para el activo: <strong>{{ $equipo->serial }}</strong>)
                </h3>
            </div>

            <form action="{{ route('equipos.wizard.saveDiscoduro', $equipo) }}" method="POST">
                @csrf
                
                <div class="card-body">

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-1"></i> 
                        Registre la unidad de almacenamiento principal del equipo.
                    </div>

                    <div class="row">
                        {{-- COLUMNA IZQUIERDA --}}
                        <div class="col-md-6">
                            
                            {{-- Capacidad --}}
                            <div class="form-group">
                                <label for="capacidad"><i class="fas fa-archive"></i> Capacidad</label>
                                <input type="text" id="capacidad" class="form-control" name="capacidad" 
                                    value="{{ old('capacidad') }}" placeholder="Ej. 500GB, 1TB, 256GB">
                                @error('capacidad') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            {{-- Tipo HDD/SSD --}}
                            <div class="form-group">
                                <label for="tipo_hdd_ssd"><i class="fas fa-memory"></i> Tipo HDD/SSD</label>
                                <input type="text" id="tipo_hdd_ssd" class="form-control" name="tipo_hdd_ssd" 
                                    value="{{ old('tipo_hdd_ssd') }}" placeholder="Ej. SSD, NVMe, HDD">
                                @error('tipo_hdd_ssd') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                        </div>

                        {{-- COLUMNA DERECHA --}}
                        <div class="col-md-6">

                            {{-- Interface --}}
                            <div class="form-group">
                                <label for="interface"><i class="fas fa-plug"></i> Interfaz</label>
                                <input type="text" id="interface" class="form-control" name="interface" 
                                    value="{{ old('interface') }}" placeholder="Ej. SATA III, PCIe, M.2">
                                @error('interface') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-chevron-circle-right"></i> Guardar Disco Duro y Continuar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection