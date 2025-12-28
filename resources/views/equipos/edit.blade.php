@extends('adminlte::page')

@section('title', 'Editar Equipo | Activos TI')

@section('css')
<style>
    .section-title {
        border-bottom: 2px solid #007bff; 
        padding-bottom: 5px;
        margin-bottom: 15px;
        color: #17a2b8; 
        font-weight: 600;
    }

    .data-item {
        margin-bottom: 10px;
        padding-bottom: 5px;
        border-bottom: 1px dashed #ced4da;
    }

    .data-item:last-child {
        border-bottom: none;
    }

    .data-label {
        font-weight: 600;
        color: #495057;
    }

    .component-group {
        border: 1px solid #dee2e6;
        border-radius: .25rem;
        padding: 15px;
        margin-bottom: 20px;
        background-color: #f8f9fa;
    }
</style>
@stop

@section('content_header')
    <h1 class="font-weight-bold text-center">
        <i class="fas fa-desktop text-primary"></i> 
        Edición de Activo: {{ strtoupper($equipo->marca_equipo) }}
    </h1>
    <a href="{{ route('equipos.index') }}" class="btn btn-outline-secondary btn-sm mt-2">
        <i class="fas fa-arrow-circle-left"></i> Volver a Inventario
    </a>
@stop


@section('content')
    <div class="container-fluid">
        <div class="row">

            {{-- COLUMNA IZQUIERDA: DATOS ACTUALES Y RELACIONES (Visibilidad) --}}
            <div class="col-md-5">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-clipboard-list"></i> **Detalle y Estado Actual**
                        </h3>
                    </div>
                    <div class="card-body">
                        
                        <h5 class="section-title"><i class="fas fa-cogs"></i> Especificaciones Generales</h5>
                        
                        {{-- Datos Principales --}}
                        <div class="data-item">
                            <span class="data-label">Marca/Modelo:</span> 
                            <span class="float-right">{{ $equipo->marca_equipo }}</span>
                        </div>
                        <div class="data-item">
                            <span class="data-label">Tipo de Equipo:</span> 
                            <span class="float-right">{{ $equipo->tipo_equipo }}</span>
                        </div>
                        <div class="data-item">
                            <span class="data-label">Serial:</span> 
                            <span class="float-right text-bold">{{ $equipo->serial }}</span>
                        </div>
                        <div class="data-item">
                            <span class="data-label"><i class="fab fa-windows"></i> S. Operativo:</span> 
                            <span class="float-right">{{ $equipo->sistema_operativo }}</span>
                        </div>
                        
                        <hr class="mt-4">

                        <h5 class="section-title"><i class="fas fa-users-cog"></i> Responsabilidad y Ubicación</h5>

                        <div class="data-item">
                            <span class="data-label"><i class="fas fa-user-tag"></i> Usuario:</span> 
                            <span class="float-right text-primary">{{ $equipo->usuario->name ?? 'Sin asignar' }}</span>
                        </div>
                        <div class="data-item">
                            <span class="data-label"><i class="fas fa-map-marker-alt"></i> Ubicación:</span> 
                            <span class="float-right text-primary">{{ $equipo->ubicacion->nombre ?? 'Sin ubicar' }}</span>
                        </div>

                        <hr class="mt-4">

                        <h5 class="section-title"><i class="fas fa-money-bill-wave"></i> Información Contable</h5>

                        <div class="data-item">
                            <span class="data-label">Valor Inicial:</span> 
                            <span class="float-right text-success text-bold">${{ number_format($equipo->valor_inicial, 2) }}</span>
                        </div>
                        <div class="data-item">
                            <span class="data-label">F. Adquisición:</span> 
                            <span class="float-right">{{ $equipo->fecha_adquisicion }}</span>
                        </div>
                        <div class="data-item">
                            <span class="data-label">Vida Útil Estimada:</span> 
                            <span class="float-right">{{ $equipo->vida_util_estimada }}</span>
                        </div>

                        <hr class="mt-4">

                        <h5 class="section-title"><i class="fas fa-puzzle-piece"></i> Componentes Asociados ({{ $equipo->perifericos->count() + $equipo->rams->count() + $equipo->procesadores->count() + $equipo->monitores->count() + $equipo->discosDuros->count() }})</h5>

                        {{-- Detalle Periféricos --}}
                        <h6><i class="fas fa-keyboard text-warning"></i> **Periféricos ({{ $equipo->perifericos->count() }})**</h6>
                        <ul class="list-unstyled mb-3 ml-3">
                            @forelse($equipo->perifericos as $p)
                                <li>- {{ $p->tipo }} (Serial: {{ $p->serial }})</li>
                            @empty
                                <li class="text-muted">Ninguno.</li>
                            @endforelse
                        </ul>

                        {{-- Detalle RAMs --}}
                        <h6><i class="fas fa-memory text-warning"></i> **RAM ({{ $equipo->rams->count() }})**</h6>
                        <ul class="list-unstyled mb-3 ml-3">
                            @forelse($equipo->rams as $r)
                                <li>- {{ $r->capacidad_gb }}GB | {{ $r->tipo_chz }}</li>
                            @empty
                                <li class="text-muted">Ninguna.</li>
                            @endforelse
                        </ul>
                        
                        {{-- Detalle Procesadores --}}
                        <h6><i class="fas fa-microchip text-warning"></i> **Procesador ({{ $equipo->procesadores->count() }})**</h6>
                        <ul class="list-unstyled mb-3 ml-3">
                            @forelse($equipo->procesadores as $proc)
                                <li>- {{ $proc->marca }} | {{ $proc->descripcion_tipo }}</li>
                            @empty
                                <li class="text-muted">Ninguno.</li>
                            @endforelse
                        </ul>

                        {{-- Detalle Monitores --}}
                        <h6><i class="fas fa-tv text-warning"></i> **Monitores ({{ $equipo->monitores->count() }})**</h6>
                        <ul class="list-unstyled mb-3 ml-3">
                            @forelse($equipo->monitores as $mon)
                                <li>- {{ $mon->marca }} ({{ $mon->escala_pulgadas }}")</li>
                            @empty
                                <li class="text-muted">Ninguno.</li>
                            @endforelse
                        </ul>

                        {{-- Detalle Discos Duros --}}
                        <h6><i class="fas fa-hdd text-warning"></i> **Discos ({{ $equipo->discosDuros->count()}})**</h6>
                        <ul class="list-unstyled mb-3 ml-3">
                            @forelse($equipo->discosDuros as $dd)
                                <li>- {{ $dd->capacidad }} {{ $dd->tipo_hdd_ssd }}</li>
                            @empty
                                <li class="text-muted">Ninguno.</li>
                            @endforelse
                        </ul>

                    </div> {{-- /card-body --}}
                </div> {{-- /card --}}
            </div> {{-- /col-md-5 --}}

            {{-- COLUMNA DERECHA: FORMULARIO DE EDICIÓN (Funcionalidad) --}}
            <div class="col-md-7">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-pen-square"></i> **Modificación de Datos**
                        </h3>
                    </div>
                    <div class="card-body">
                        
                        <form action="{{ route('equipos.update', $equipo) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- SECCIÓN DATOS GENERALES EDITABLES --}}
                            <fieldset class="border p-3 mb-4">
                                <legend class="w-auto px-2 text-primary"><i class="fas fa-info-circle"></i> Datos Base</legend>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="marca_equipo"><i class="fas fa-tag"></i> Marca del Equipo</label>
                                        <input type="text" name="marca_equipo" id="marca_equipo" class="form-control"
                                            value="{{ old('marca_equipo', $equipo->marca_equipo) }}">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="tipo_equipo"><i class="fas fa-laptop"></i> Tipo de Equipo</label>
                                        <input type="text" name="tipo_equipo" id="tipo_equipo" class="form-control"
                                            value="{{ old('tipo_equipo', $equipo->tipo_equipo) }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="serial"><i class="fas fa-barcode"></i> Serial</label>
                                        <input type="text" name="serial" id="serial" class="form-control"
                                            value="{{ old('serial', $equipo->serial) }}">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="sistema_operativo"><i class="fab fa-windows"></i> Sistema Operativo</label>
                                        <input type="text" name="sistema_operativo" id="sistema_operativo" class="form-control"
                                            value="{{ old('sistema_operativo', $equipo->sistema_operativo) }}">
                                    </div>
                                </div>
                            </fieldset>

                            {{-- SECCIÓN DATOS ASOCIADOS (Dropdowns) --}}
                            <fieldset class="border p-3 mb-4">
                                <legend class="w-auto px-2 text-primary"><i class="fas fa-link"></i> Asignación</legend>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="usuario_id"><i class="fas fa-user-tag"></i> Usuario Responsable</label>
                                        <select name="usuario_id" id="usuario_id" class="form-control select2" data-placeholder="Seleccione un usuario">
                                            <option value="">Seleccione...</option>
                                            @foreach($usuarios as $usuario)
                                            <option value="{{ $usuario->id }}"
                                                {{ $equipo->usuario_id == $usuario->id ? 'selected' : '' }}>
                                                {{ $usuario->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="ubicacion_id"><i class="fas fa-map-marker-alt"></i> Ubicación</label>
                                        <select name="ubicacion_id" id="ubicacion_id" class="form-control select2" data-placeholder="Seleccione la ubicación">
                                            <option value="">Seleccione...</option>
                                            @foreach($ubicaciones as $ubicacion)
                                            <option value="{{ $ubicacion->id }}"
                                                {{ $equipo->ubicacion_id == $ubicacion->id ? 'selected' : '' }}>
                                                {{ $ubicacion->nombre }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="valor_inicial"><i class="fas fa-dollar-sign"></i> Valor Inicial</label>
                                        <input type="number" name="valor_inicial" id="valor_inicial" class="form-control" step="0.01"
                                            value="{{ old('valor_inicial', $equipo->valor_inicial) }}">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="fecha_adquisicion"><i class="fas fa-calendar-alt"></i> Fecha de Adquisición</label>
                                        <input type="date" name="fecha_adquisicion" id="fecha_adquisicion" class="form-control"
                                            value="{{ old('fecha_adquisicion', $equipo->fecha_adquisicion) }}">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="vida_util_estimada"><i class="fas fa-hourglass-half"></i> Vida Útil Estimada</label>
                                        <input type="text" name="vida_util_estimada" id="vida_util_estimada" class="form-control"
                                            value="{{ old('vida_util_estimada', $equipo->vida_util_estimada) }}">
                                    </div>
                                </div>
                            </fieldset>


                            {{-- SECCIÓN COMPONENTES EDITABLES --}}
                            <h5 class="section-title mt-4"><i class="fas fa-tools"></i> Edición Detallada de Componentes</h5>

                            <div id="componentes-editables">

                                {{-- Periféricos --}}
                                <div class="component-group">
                                    <h6 class="text-info"><i class="fas fa-keyboard"></i> Periféricos (Editables)</h6>

                                    <button type="button"
                                        class="btn btn-sm btn-outline-primary mt-2"
                                        onclick="agregarPeriferico()">
                                        <i class="fas fa-plus"></i> Agregar periférico0
                                    </button>

                                    <hr class="my-2">
                                    <div id="perifericos-container"
                                     data-perifericos-count="{{ $equipo->perifericos->count() }}">
                                        @foreach($equipo->perifericos as $index => $periferico)
                                        <div class="periferico-item">
                                        <div class="p-2 mb-2 border rounded bg-white">
                                            <h6 class="text-secondary"><i class="fas fa-dot-circle"></i> Periférico #{{ $index + 1 }} </h6>
                                            <input type="hidden" name="perifericos[{{ $index }}][id]" value="{{ $periferico->id }}"> 
                                            <input type="hidden" name="perifericos[{{ $index }}][_delete]" value="">

                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label>Tipo / Marca</label>
                                                        <input type="text" name="perifericos[{{ $index }}][tipo]" class="form-control form-control-sm"
                                                        placeholder="Ej: Teclado, Monitor, Mouse"
                                                        value="{{ old('perifericos.' . $index . '.tipo', $periferico->tipo ?? '') }}">
                                                    </div>
                                                </div>

                                        
                                                <div class="form-group col-md-6">
                                                    <label>Serial</label>
                                                    <input type="text" name="perifericos[{{ $index }}][serial]" class="form-control form-control-sm"
                                                        placeholder="Serial del periférico"
                                                        value="{{ old('perifericos.' . $index . '.serial', $periferico->serial ?? '') }}">
                                                </div>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger mt-2"
                                                        onclick="eliminarPeriferico(this)">
                                                        <i class="fas fa-plus"></i> Eliminar periférico
                                                    </button>

                                                </div>


                                        </div>
                                        @endforeach
                                    </div>



                                </div>

                                {{-- Rams --}}
                                <div class="component-group">

                                    <h6 class="text-info"><i class="fas fa-memory"></i> Módulos RAM (Editables)</h6>
                                    
                                    <button type="button"
                                        class="btn btn-sm btn-outline-primary mt-2"
                                        onclick="agregarRam()">
                                        <i class="fas fa-plus"></i> Agregar Ram
                                    </button>
                                    
                                    <hr class="my-2">
                                    <div id="rams-container"
                                     data-rams-count="{{ $equipo->rams->count() }}">
                    
                                        @foreach($equipo->rams as $index => $ram)
                                        <div class="ram-item">
                                        <div class="p-2 mb-2 border rounded bg-white">
                                            <h6 class="text-secondary"><i class="fas fa-dot-circle"></i> RAM #{{ $index + 1 }} </h6>
                                            <input type="hidden" name="rams[{{ $index }}][id]" value="{{ $ram->id }}">
                                            <input type="hidden" name="rams[{{ $index }}][_delete]" value="">
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label>Capacidad (GB)</label>
                                                    <input type="text" name="rams[{{$index}}][capacidad_gb]" class="form-control form-control-sm"
                                                        value="{{ old('rams.' . $index . '.capacidad_gb', $ram->capacidad_gb ?? '') }}" placeholder="Ej: 8">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label>Clock (MHz)</label>
                                                    <input type="text" name="rams[{{$index}}][clock_mhz]" class="form-control form-control-sm"
                                                        value="{{ old('rams.' . $index . '.clock_mhz', $ram->clock_mhz ?? '') }}" placeholder="Ej: 3200">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label>Tipo (DDR)</label>
                                                    <input type="text" name="rams[{{$index}}][tipo_chz]" class="form-control form-control-sm"
                                                        value="{{ old('rams.' . $index . '.tipo_chz', $ram->tipo_chz ?? '') }}" placeholder="Ej: DDR4">
                                                </div> 

                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger mt-2"
                                                        onclick="eliminarRam(this)">
                                                        <i class="fas fa-trash"></i> Eliminar Ram
                                                    </button>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Procesadores --}}
                                <div class="component-group">
                                    <h6 class="text-info"><i class="fas fa-microchip"></i> Procesadores (Editables)</h6>
                                        <button type="button"
                                        class="btn btn-sm btn-outline-primary mt-2"
                                        onclick="agregarProcesador()">
                                        <i class="fas fa-plus"></i> Agregar Procesador
                                    </button>
                                    <hr class="my-2">
                                    <div id="procesadores-container"data-procesadores-count="{{ $equipo->procesadores->count() }}">
                                        @foreach($equipo->procesadores as $index => $procesador)
                                        <div class="p-2 mb-2 border rounded bg-white">
                        
                                            <h6 class="text-secondary"><i class="fas fa-dot-circle"></i> Procesador #{{ $index + 1 }} </h6>
                                            <input type="hidden" name="procesadores[{{ $index }}][id]" value="{{ $procesador->id }}">
                                            <input type="hidden" name="procesadores[{{ $index }}][_delete]" value="">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label>Marca</label>
                                                    <input type="text" name="procesadores[{{$index}}][marca]" class="form-control form-control-sm"
                                                        value="{{ old('procesadores.' . $index . '.marca', $procesador->marca ?? '') }}" placeholder="Ej: Intel, AMD">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Descripción / Modelo</label>
                                                    <input type="text" name="procesadores[{{$index}}][descripcion_tipo]" class="form-control form-control-sm"
                                                        value="{{ old('procesadores.' . $index . '.descripcion_tipo', $procesador->descripcion_tipo ?? '') }}" placeholder="Ej: Core i5-10400F">
                                                </div> 

                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger mt-2"
                                                    onclick="eliminarProcesador(this)">
                                                    <i class="fas fa-trash"></i> Eliminar Procesador
                                                </button>
                                            </div>
                                        </div>
                                        @endforeach

                                    </div>
                                </div>

                                {{-- Monitores --}}
                                <div class="component-group">
                                    <h6 class="text-info"><i class="fas fa-tv"></i> Monitores (Editables)</h6>
                                    <button type="button"
                                        class="btn btn-sm btn-outline-primary mt-2"
                                        onclick="agregarMonitor()">
                                        <i class="fas fa-plus"></i> Agregar Procesador
                                    </button>
                                    <hr class="my-2">
                                   <div id="monitores-container"
                                    data-monitores-count="{{ $equipo->monitores->count() }}">
                                    @foreach($equipo->monitores as $index => $monitor)
                                    <div class="monitor-item">
                                        <div class="p-2 mb-2 border rounded bg-white">
                                            <h6 class="text-secondary">
                                                <i class="fas fa-dot-circle"></i> Monitor #{{ $index + 1 }}
                                            </h6>

                                            <input type="hidden" name="monitores[{{ $index }}][id]" value="{{ $monitor->id }}">
                                            <input type="hidden" name="monitores[{{ $index }}][_delete]" value="">

                                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <label>Marca</label>
                                                    <input type="text"
                                                        name="monitores[{{ $index }}][marca]"
                                                        class="form-control form-control-sm"
                                                        value="{{ $monitor->marca }}">
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label>Serial</label>
                                                    <input type="text"
                                                        name="monitores[{{ $index }}][serial]"
                                                        class="form-control form-control-sm"
                                                        value="{{ $monitor->serial }}">
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label>Pulgadas</label>
                                                    <input type="text"
                                                        name="monitores[{{ $index }}][escala_pulgadas]"
                                                        class="form-control form-control-sm"
                                                        value="{{ $monitor->escala_pulgadas }}">
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label>Interfaz</label>
                                                    <input type="text"
                                                        name="monitores[{{ $index }}][interface]"
                                                        class="form-control form-control-sm"
                                                        value="{{ $monitor->interface }}">
                                                </div>
                                            </div>

                                            <button type="button"
                                                    class="btn btn-sm btn-outline-danger mt-2"
                                                    onclick="eliminarMonitor(this)">
                                                <i class="fas fa-trash"></i> Eliminar Monitor
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                    </div>
                                </div>

                                {{-- Discos Duros --}}
                                <div class="component-group">
                                    <h6 class="text-info"><i class="fas fa-hdd"></i> Discos Duros (Editables)</h6>

                                    <button type="button"
                                        class="btn btn-sm btn-outline-primary mt-2"
                                        onclick="agregarDiscoDuro()">
                                        <i class="fas fa-plus"></i> Agregar Disco Duro
                                    </button>

                                    <hr class="my-2">

                                    {{-- SOLO discos aquí --}}
                                    <div id="discosDuros-container" 
                                    data-discos-count="{{ $equipo->discosDuros->count() }}">
                                        @foreach($equipo->discosDuros as $index => $discoDuro)
                                            <div class="disco-item p-2 mb-2 border rounded bg-white">
                                                <h6 class="text-secondary">
                                                    <i class="fas fa-dot-circle"></i> Disco Duro #{{ $index + 1 }}
                                                </h6>

                                                <input type="hidden" name="discoDuros[{{ $index }}][id]" value="{{ $discoDuro->id }}">
                                                <input type="hidden" name="discoDuros[{{ $index }}][_delete]" value="">

                                                <div class="row">
                                                    <div class="form-group col-md-4">
                                                        <label>Capacidad (GB/TB)</label>
                                                        <input type="text" name="discoDuros[{{$index}}][capacidad]" class="form-control form-control-sm"
                                                        value="{{ $discoDuro->capacidad }}"
                                                        >
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label>Tipo (HDD/SSD)</label>
                                                        <input type="text" name="discoDuros[{{$index}}][tipo_hdd_ssd]" class="form-control form-control-sm"
                                                        value="{{ $discoDuro->tipo_hdd_ssd }}"
                                                        >
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label>Interface</label>
                                                        <input type="text" name="discoDuros[{{$index}}][interface]" class="form-control form-control-sm"
                                                        value="{{ $discoDuro->interface }}"
                                                        >
                                                    </div>
                                                </div>

                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger mt-2"
                                                    onclick="eliminarDiscoDuro(this)">
                                                    <i class="fas fa-trash"></i> Eliminar Disco
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- BOTÓN FINAL (FUERA DE TODO COMPONENT-GROUP) --}}
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-success btn-lg btn-block">
                                        <i class="fas fa-database"></i> Aplicar Cambios y Registrar Historial
                                    </button>
                                </div>





                        </form>
                    </div> {{-- /card-body --}}
                </div> {{-- /card --}}
            </div> {{-- /col-md-7 --}}
        </div> {{-- row --}}
    </div> {{-- container --}}

@stop

{{-- -------------------------------------------------------------------------------- --}}
{{-- Scripts Adicionales (Para Select2 si estás usándolo) --}}
@section('js')
    {{-- Asegúrate de que Select2 esté inicializado si se usa en los dropdowns --}}
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
            });
        });


//LOGICA PARA AGREGAR PERIFERICOS
//Variable que toma el numero de perifericos, o bien de relaciones

//Condicion 

//PERIFERICOS.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-
const container = document.getElementById('perifericos-container');
let perifericoIndex = parseInt(container.dataset.perifericosCount);
function agregarPeriferico(){

    //Tomamos el container de los perifericos
    const container = document.getElementById('perifericos-container')

    // Agregamos la seccion HTML
    const html = `
    <div class="periferico-item">
        <input type="hidden"
        name="perifericos[${perifericoIndex}][_delete]"
        value="">
        <div class="p-2 mb-2 border rounded bg-white">
            <h6 class="text-secondary">
                <h6 class="text-secondary">
                <i class="fas fa-dot-circle"></i> Periférico #${perifericoIndex + 1}
                </h6>
            </h6>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Tipo / Marca</label>
                    <input type="text"
                           name="perifericos[${perifericoIndex}][tipo]"
                           class="form-control form-control-sm"
                           placeholder="Ej: Teclado, Mouse, Monitor">
                </div>

                <div class="form-group col-md-6">
                    <label>Serial</label>
                    <input type="text"
                           name="perifericos[${perifericoIndex}][serial]"
                           class="form-control form-control-sm"
                           placeholder="Serial del periférico">
                </div>
            </div>
            <button type="button"
                class="btn btn-sm btn-outline-danger mt-2"
                onclick="eliminarPeriferico(this)">
                <i class="fas fa-plus"></i> Eliminar periférico
            </button>
        </div>

        </div>
        `;

    container.insertAdjacentHTML('beforeend', html);
    perifericoIndex++;
};

//Eliminar Periferico
function eliminarPeriferico(btn) {
    if (!confirm('¿Deseas eliminar este periférico?')) {
        return;
    }
    const item = btn.closest('.periferico-item');
    // 1. marcar eliminación
    const deleteInput = item.querySelector('[name$="[_delete]"]');
    if (deleteInput) {
        deleteInput.value = 1;
    }
    // 2. vaciar los campos reales
    item.querySelectorAll('input:not([type="hidden"])')
        .forEach(input => input.value = '');
    // 3. ocultar visualmente
    item.style.display = 'none';
}
//PERIFERICOS.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-


//RAMS.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-
const containerRam = document.getElementById('rams-container');
let ramIndex = parseInt(containerRam.dataset.ramsCount);
function agregarRam() {
const containerRam = document.getElementById('rams-container')
    const html = `
    <div class="ram-item">
        <input type="hidden"
        name="rams[${ramIndex}][_delete]"
        value="">
        <div class="p-2 mb-2 border rounded bg-white">
            <h6 class="text-secondary">
                <i class="fas fa-dot-circle"></i> RAM #${ramIndex + 1}
            </h6>

            <!-- input oculto para control de eliminación -->
   

            <div class="row">
                <div class="form-group col-md-4">
                    <label>Capacidad (GB)</label>
                    <input type="text"
                        name="rams[${ramIndex}][capacidad_gb]"
                        class="form-control form-control-sm"
                        placeholder="Ej: 8">
                </div>

                <div class="form-group col-md-4">
                    <label>Clock (MHz)</label>
                    <input type="text"
                        name="rams[${ramIndex}][clock_mhz]"
                        class="form-control form-control-sm"
                        placeholder="Ej: 3200">
                </div>

                <div class="form-group col-md-4">
                    <label>Tipo (DDR)</label>
                    <input type="text"
                        name="rams[${ramIndex}][tipo_chz]"
                        class="form-control form-control-sm"
                        placeholder="Ej: DDR4">
                </div>
            </div>

            <button type="button"
                class="btn btn-sm btn-outline-danger mt-2"
                onclick="eliminarRam(this)">
                <i class="fas fa-trash"></i> Eliminar RAM
            </button>
        </div>
    </div>
    `;

    containerRam.insertAdjacentHTML('beforeend', html);
    ramIndex++;
}

// Eliminar RAM (soft delete)
function eliminarRam(btn) {
    if (!confirm('¿Deseas eliminar esta RAM?')) {
        return;
    }

    const item = btn.closest('.ram-item');

    // 1. marcar eliminación
    const deleteInput = item.querySelector('[name$="[_delete]"]');
    if (deleteInput) {
        deleteInput.value = 1;
    }

    // 2. vaciar inputs visibles
    item.querySelectorAll('input:not([type="hidden"])')
        .forEach(input => input.value = '');

    // 3. ocultar visualmente
    item.style.display = 'none';
}


//PROCESADOR.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-
const containerProcesador = document.getElementById('procesadores-container');
let procesadorIndex = parseInt(containerProcesador.dataset.procesadoresCount);
function agregarProcesador() {

    const container = document.getElementById('procesadores-container');

    const html = `
    <div class="procesador-item">
        <input type="hidden"
               name="procesadores[${procesadorIndex}][_delete]"
               value="">

        <div class="p-2 mb-2 border rounded bg-white">
            <h6 class="text-secondary">
                <i class="fas fa-dot-circle"></i> Procesador #${procesadorIndex + 1}
            </h6>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Marca</label>
                    <input type="text"
                           name="procesadores[${procesadorIndex}][marca]"
                           class="form-control form-control-sm"
                           placeholder="Ej: Intel, AMD">
                </div>

                <div class="form-group col-md-6">
                    <label>Descripción / Modelo</label>
                    <input type="text"
                           name="procesadores[${procesadorIndex}][descripcion_tipo]"
                           class="form-control form-control-sm"
                           placeholder="Ej: Core i5-10400F">
                </div>
            </div>

            <button type="button"
                    class="btn btn-sm btn-outline-danger mt-2"
                    onclick="eliminarProcesador(this)">
                <i class="fas fa-trash"></i> Eliminar Procesador
            </button>
        </div>
    </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    procesadorIndex++;
}



function eliminarProcesador(btn) {
    if (!confirm('¿Deseas eliminar este procesador?')) {
        return;
    }

    const item = btn.closest('.procesador-item');

    // 1. marcar eliminación
    const deleteInput = item.querySelector('[name$="[_delete]"]');
    if (deleteInput) {
        deleteInput.value = 1;
    }

    // 2. vaciar inputs visibles
    item.querySelectorAll('input:not([type="hidden"])')
        .forEach(input => input.value = '');

    // 3. ocultar visualmente
    item.style.display = 'none';
}



//MONITOR.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-
const containerMonitor = document.getElementById('monitores-container');
let monitorIndex = parseInt(containerMonitor.dataset.monitoresCount);

function agregarMonitor() {
const container = document.getElementById('monitores-container');
    const html = `
    <div class="monitor-item">
        <input type="hidden"
               name="monitores[${monitorIndex}][_delete]"
               value="">

        <div class="p-2 mb-2 border rounded bg-white">
            <h6 class="text-secondary">
                <i class="fas fa-dot-circle"></i> Monitor #${monitorIndex + 1}
            </h6>

            <div class="row">
                <div class="form-group col-md-3">
                    <label>Marca</label>
                    <input type="text"
                           name="monitores[${monitorIndex}][marca]"
                           class="form-control form-control-sm">
                </div>

                <div class="form-group col-md-3">
                    <label>Serial</label>
                    <input type="text"
                           name="monitores[${monitorIndex}][serial]"
                           class="form-control form-control-sm">
                </div>

                <div class="form-group col-md-3">
                    <label>Pulgadas</label>
                    <input type="text"
                           name="monitores[${monitorIndex}][escala_pulgadas]"
                           class="form-control form-control-sm">
                </div>

                <div class="form-group col-md-3">
                    <label>Interfaz</label>
                    <input type="text"
                           name="monitores[${monitorIndex}][interface]"
                           class="form-control form-control-sm">
                </div>
            </div>

            <button type="button"
                    class="btn btn-sm btn-outline-danger mt-2"
                    onclick="eliminarMonitor(this)">
                <i class="fas fa-trash"></i> Eliminar Monitor
            </button>
        </div>
    </div>
    `;

    containerMonitor.insertAdjacentHTML('beforeend', html);
    monitorIndex++;
}

function eliminarMonitor(btn) {
    if (!confirm('¿Deseas eliminar este monitor?')) {
        return;
    }

    const item = btn.closest('.monitor-item');

    const deleteInput = item.querySelector('[name$="[_delete]"]');
    if (deleteInput) {
        deleteInput.value = 1;
    }

    item.querySelectorAll('input:not([type="hidden"])')
        .forEach(input => input.value = '');

    item.style.display = 'none';
}

//DISCOS DUROS.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-
const containerDiscoDuro = document.getElementById('discosDuros-container');
let discoDuroIndex = parseInt(containerDiscoDuro.dataset.discosCount);

function agregarDiscoDuro() {
const container = document.getElementById('discosDuros-container');
    const html = `
    <div class="disco-item">
        <input type="hidden"
               name="discoDuros[${discoDuroIndex}][_delete]"
               value="">

        <div class="p-2 mb-2 border rounded bg-white">
            <h6 class="text-secondary">
                <i class="fas fa-dot-circle"></i> Disco Duro #${discoDuroIndex + 1}
            </h6>

            <div class="row">
                <div class="form-group col-md-4">
                    <label>Capacidad (GB/TB)</label>
                    <input type="text"
                           name="discoDuros[${discoDuroIndex}][capacidad]"
                           class="form-control form-control-sm"
                           placeholder="Ej: 500GB">
                </div>

                <div class="form-group col-md-4">
                    <label>Tipo (HDD/SSD)</label>
                    <input type="text"
                           name="discoDuros[${discoDuroIndex}][tipo_hdd_ssd]"
                           class="form-control form-control-sm"
                           placeholder="Ej: SSD">
                </div>

                <div class="form-group col-md-4">
                    <label>Interface</label>
                    <input type="text"
                           name="discoDuros[${discoDuroIndex}][interface]"
                           class="form-control form-control-sm"
                           placeholder="Ej: SATA, NVMe">
                </div>
            </div>

            <button type="button"
                    class="btn btn-sm btn-outline-danger mt-2"
                    onclick="eliminarDiscoDuro(this)">
                <i class="fas fa-trash"></i> Eliminar Disco
            </button>
        </div>
    </div>
    `;

    containerDiscoDuro.insertAdjacentHTML('beforeend', html);
    discoDuroIndex++;
}

function eliminarDiscoDuro(btn) {
    if (!confirm('¿Deseas eliminar este disco duro?')) {
        return;
    }

    const item = btn.closest('.disco-item');

    // 1. marcar eliminación
    const deleteInput = item.querySelector('[name$="[_delete]"]');
    if (deleteInput) {
        deleteInput.value = 1;
    }

    // 2. vaciar inputs visibles
    item.querySelectorAll('input:not([type="hidden"])')
        .forEach(input => input.value = '');

    // 3. ocultar visualmente
    item.style.display = 'none';
}


    </script>
@stop