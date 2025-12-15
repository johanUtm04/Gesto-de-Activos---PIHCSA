@extends('adminlte::page')

@section('title', 'Inventario de Activos TI')

{{-- -------------------------------------------------------------------------------- --}}
{{-- Estilos personalizados (mejor legibilidad de datos complejos) --}}
@section('css')
<style>
    /* Estilo para hacer la tabla más legible */
    .table-assets thead th {
        /* Un fondo limpio y un borde inferior que resalte */
        background-color: #e9ecef; /* Light gray background for header */
        color: #17a2b8; /* Info color text for prominence */
        font-weight: 700;
        border-bottom: 3px solid #17a2b8; /* Borde inferior que coincide con el color del título */
        vertical-align: middle;
        padding: 10px;
    }

    /* Estilo para los TDs que contienen la información agrupada */
    .table-assets tbody td {
        vertical-align: top; /* Alinear el texto de las celdas agrupadas en la parte superior */
        font-size: 14px;
        line-height: 1.4;
    }
    
    /* Resaltar datos complejos o importantes */
    .component-count {
        font-weight: 600;
        color: #28a745; /* Color verde (Success) para indicar existencia */
    }

    /* Estilo para datos secundarios (ubicación, email) */
    .secondary-data {
        color: #6c757d; /* Gris tenue */
        font-size: 0.85em;
        display: block; /* Asegurar que ocupe su propia línea si es necesario */
    }

    /* Estilo para el modal de detalles, más limpio */
    .modal-detail-row {
        padding: 8px 0;
        border-bottom: 1px dashed #ced4da; /* Línea de puntos más sutil */
    }

    .modal-detail-row:last-child {
        border-bottom: none;
    }
    
    /* Asegurar que el botón de cerrar del modal sea visible */
    .modal-header .close {
        padding: 1rem 1rem;
        margin: -1rem -1rem -1rem auto;
    }
</style>
@stop

{{-- -------------------------------------------------------------------------------- --}}
{{-- HEADER PRINCIPAL --}}
@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-list-alt text-info"></i> Inventario de Activos Fijos (Equipos)</h1>
        <a href="{{ route('equipos.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Agregar Nuevo Equipo
        </a>
    </div>
@stop

{{-- -------------------------------------------------------------------------------- --}}
{{-- CONTENIDO PRINCIPAL --}}
@section('content')
    
    {{-- Manejo de Mensajes de Sesión (Alertas AdminLTE) --}}
    @php
        $alertTypes = ['success', 'danger', 'warning', 'info'];
    @endphp

    @foreach ($alertTypes as $msg)
        @if(Session::has($msg))
            <div class="alert alert-{{ $msg }} alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i>
                {{ Session::get($msg) }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    @endforeach

    {{-- MODAL DE DETALLES MEJORADO --}}
    <div class="modal fade" id="modalDetalle" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><i class="fas fa-search"></i> Detalles Completos del Activo</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="card card-outline card-info">
                            <div class="card-header"><h6 class="card-title"><i class="fas fa-info-circle"></i> Información Base</h6></div>
                            <div class="card-body">
                                <div class="row modal-detail-row">
                                    <div class="col-md-4 font-weight-bold"><i class="fas fa-hashtag"></i> ID:</div>
                                    <div class="col-md-8" id="modal_id"></div>
                                </div>
                                <div class="row modal-detail-row">
                                    <div class="col-md-4 font-weight-bold"><i class="fas fa-tag"></i> Marca:</div>
                                    <div class="col-md-8" id="modal_marca"></div>
                                </div>
                                <div class="row modal-detail-row">
                                    <div class="col-md-4 font-weight-bold"><i class="fas fa-laptop"></i> Tipo:</div>
                                    <div class="col-md-8" id="modal_tipo"></div>
                                </div>
                                <div class="row modal-detail-row">
                                    <div class="col-md-4 font-weight-bold"><i class="fas fa-barcode"></i> Serial:</div>
                                    <div class="col-md-8" id="modal_serial"></div>
                                </div>
                                <div class="row modal-detail-row">
                                    <div class="col-md-4 font-weight-bold"><i class="fab fa-windows"></i> SO:</div>
                                    <div class="col-md-8" id="modal_so"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-outline card-warning">
                            <div class="card-header"><h6 class="card-title"><i class="fas fa-link"></i> Asignación y Valor</h6></div>
                            <div class="card-body">
                                <div class="row modal-detail-row">
                                    <div class="col-md-4 font-weight-bold"><i class="fas fa-user-tag"></i> Usuario:</div>
                                    <div class="col-md-8" id="modal_usuario"></div>
                                </div>
                                <div class="row modal-detail-row">
                                    <div class="col-md-4 font-weight-bold"><i class="fas fa-map-marker-alt"></i> Ubicación:</div>
                                    <div class="col-md-8" id="modal_ubicacion"></div>
                                </div>
                                <div class="row modal-detail-row">
                                    <div class="col-md-4 font-weight-bold"><i class="fas fa-dollar-sign"></i> Valor Inicial:</div>
                                    <div class="col-md-8" id="modal_valo_inicial"></div>
                                </div>
                                <div class="row modal-detail-row">
                                    <div class="col-md-4 font-weight-bold"><i class="fas fa-calendar-alt"></i> F. Adquisición:</div>
                                    <div class="col-md-8" id="modal_fecha_adquisicion"></div>
                                </div>
                                <div class="row modal-detail-row">
                                    <div class="col-md-4 font-weight-bold"><i class="fas fa-hourglass-half"></i> Vida Útil Est.:</div>
                                    <div class="col-md-8" id="modal_vida_util"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-outline card-success">
                            <div class="card-header"><h6 class="card-title"><i class="fas fa-microchip"></i> Componentes (Resumen)</h6></div>
                            <div class="card-body">
                                <div class="row modal-detail-row">
                                    <div class="col-md-4 font-weight-bold"><i class="fas fa-tv"></i> Monitores:</div>
                                    <div class="col-md-8" id="modal_monitores"></div>
                                </div>
                                <div class="row modal-detail-row">
                                    <div class="col-md-4 font-weight-bold"><i class="fas fa-hdd"></i> Discos Duros:</div>
                                    <div class="col-md-8" id="modal_discos_duros"></div>
                                </div>
                                <div class="row modal-detail-row">
                                    <div class="col-md-4 font-weight-bold"><i class="fas fa-memory"></i> RAM:</div>
                                    <div class="col-md-8" id="modal_ram"></div>
                                </div>
                                <div class="row modal-detail-row">
                                    <div class="col-md-4 font-weight-bold"><i class="fas fa-microchip"></i> Procesadores:</div>
                                    <div class="col-md-8" id="modal_procesadores"></div>
                                </div>
                                <div class="row modal-detail-row">
                                    <div class="col-md-4 font-weight-bold"><i class="fas fa-keyboard"></i> Periféricos:</div>
                                    <div class="col-md-8" id="modal_perifericos"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> {{-- /modal-body --}}
            </div> {{-- /modal-content --}}
        </div> {{-- /modal-dialog --}}
    </div> {{-- /modal --}}


    {{-- TABLA DE INVENTARIO --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-assets">
                    {{-- Encabezados --}}
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th><i class="fas fa-tag"></i> Activo / Serial</th>
                            <th><i class="fas fa-user-tag"></i> Asignación</th>
                            <th><i class="fas fa-map-marker-alt"></i> Ubicación</th>
                            <th><i class="fas fa-dollar-sign"></i> Valor Inicial</th>
                            <th><i class="fas fa-microchip"></i> CPU / RAM</th>
                            <th><i class="fas fa-puzzle-piece"></i> Otros Componentes</th>
                            <th class="text-center"><i class="fas fa-cogs"></i> Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($equipos as $equipo)
                            <tr>
                                <td>{{ $equipo->id }}</td>
                                
                                {{-- ACTIVO / SERIAL (Agrupado) --}}
                                <td>
                                    <strong>{{ $equipo->marca_equipo ?? '-' }}</strong> ({{ $equipo->tipo_equipo }})<br>
                                    <span class="secondary-data"><i class="fas fa-barcode"></i> Serial: {{ $equipo->serial }}</span><br>
                                    <span class="secondary-data"><i class="fab fa-windows"></i> SO: {{ $equipo->sistema_operativo }}</span>
                                </td>

                                {{-- USUARIO --}}
                                <td>
                                    <strong>{{ $equipo->usuario->name ?? 'Sin asignar' }}</strong>
                                    <br>
                                    <span class="secondary-data"><i class="fas fa-envelope"></i> {{ $equipo->usuario->email ?? '-' }}</span>
                                </td>

                                {{-- UBICACIÓN --}}
                                <td>
                                    <strong>{{ $equipo->ubicacion->nombre ?? 'Sin ubicación' }}</strong>
                                    <br>
                                    <span class="secondary-data"><i class="fas fa-map-pin"></i> Código: {{ $equipo->ubicacion->codigo ?? '-' }}</span>
                                </td>

                                {{-- VALOR / FECHA --}}
                                <td>
                                    <strong class="text-success">${{ number_format($equipo->valor_inicial, 2) }}</strong><br>
                                    <span class="secondary-data">Adq: {{ $equipo->fecha_adquisicion }}</span><br>
                                    <span class="secondary-data">Vida Útil: {{ $equipo->vida_util_estimada }}</span>
                                </td>
                                
                                {{-- CPU / RAM (Agrupado) --}}
                                <td>
                                    @if($equipo->procesadores->isNotEmpty())
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="fas fa-microchip text-primary mr-1"></i>
                                            <small>CPU: {{ $equipo->procesadores->first()->marca ?? 'N/A' }}</small>
                                        </div>
                                    @endif
                                    @if($equipo->rams->isNotEmpty())
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-memory text-primary mr-1"></i>
                                            <small>RAM: {{ $equipo->rams->pluck('capacidad_gb') }} GB Total</small>
                                        </div>
                                    @endif
                                </td>

                                {{-- OTROS COMPONENTES (Resumen) --}}
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-tv text-secondary mr-1"></i> Monitores: 
                                        <span class="component-count ml-1">{{ $equipo->monitores->count() }}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-hdd text-secondary mr-1"></i> Discos: 
                                        <span class="component-count ml-1">{{ $equipo->discosDuros->count() }}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-keyboard text-secondary mr-1"></i> Periféricos: 
                                        <span class="component-count ml-1">{{ $equipo->perifericos->count() }}</span>
                                    </div>
                                </td>

                                {{-- Acciones --}}
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">

                                    @if(in_array(auth()->user()->rol,['Admin', 'Sistemas']))
                                        {{-- Botón Ver Detalles (Modal) --}}
                                        <button class="btn btn-outline-info" title="Ver Detalles"
                                            data-toggle="modal" 
                                            data-target="#modalDetalle"
                                            data-id="{{ $equipo->id }}"
                                            data-marca="{{$equipo->marca_equipo ?? '-' }}"
                                            data-tipo="{{$equipo->tipo_equipo }}"
                                            data-serial="{{$equipo->serial }}"
                                            data-so="{{ $equipo->sistema_operativo }}"
                                            data-usuario="{{ $equipo->usuario->name ?? 'Sin asignar' }}"
                                            data-ubicacion="{{ $equipo->ubicacion->nombre ?? 'Sin ubicación' }}"
                                            data-valo-inicial="${{ number_format($equipo->valor_inicial, 2) }}"
                                            data-fecha-adquisicion="{{ $equipo->fecha_adquisicion ?? 'sin asignar' }}"
                                            data-vida-util="{{ $equipo->vida_util_estimada ?? 'sin asignar'}}"
                                            data-monitores="{{ $equipo->monitores->count() }}"
                                            data-discos-duros="{{ $equipo->discosDuros->count() }}"
                                            data-ram="{{ $equipo->rams->pluck('capacidad_gb') }} GB ({{ $equipo->rams->count() }} Módulos)"
                                            data-perifericos="{{ $equipo->perifericos->pluck('tipo')->implode(', ') }}"
                                            data-procesadores="{{ $equipo->procesadores->count() }}"
                                            >
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        
                                        {{-- Botón Editar --}}
                                        <a href="{{ route('equipos.edit', $equipo) }}" class="btn btn-outline-warning" title="Editar Activo">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        {{-- Botón Mantenimiento --}}
                                        <a href="{{ route('equipos.addwork.index', $equipo) }}" class="btn btn-outline-primary" title="Registrar Mantenimiento">
                                            <i class="fas fa-tools"></i>
                                        </a>

                                        {{-- Botón Eliminar --}}
                                        @if(in_array(auth()->user()->rol,['Admin']))
                                        <form action="{{ route('equipos.destroy', $equipo) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-outline-danger" title="Eliminar Activo"
                                                onclick="return confirm('¿Confirma la eliminación del equipo: {{ $equipo->marca_equipo }}? Esto eliminará todos sus componentes asociados.')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                        
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> {{-- /table-responsive --}}
        </div> {{-- /card-body --}}
    </div> {{-- /card --}}

@stop

{{-- -------------------------------------------------------------------------------- --}}
{{-- SCRIPTS (AdminLTE usa jQuery para modales, no Bootstrap 5 puro) --}}
@section('js')
    {{-- **Nota:** AdminLTE y Bootstrap 4 usan data-toggle/data-target y un modal.addEventListener de jQuery, no el addEventListener de Bootstrap 5. --}}
    <script>
        $(document).ready(function() {
            $('#modalDetalle').on('show.bs.modal', function (event) {
                const button = $(event.relatedTarget); // Botón que disparó el modal
                const modal = $(this);

                // Función para obtener atributos y limpiar/formatear valores
                const getAttr = (attr) => button.data(attr);
                
                // Actualizar el título del modal
                modal.find('.modal-title').text('Detalles del Activo: ' + getAttr('marca'));

                // Información Base
                modal.find('#modal_id').text(getAttr('id'));
                modal.find('#modal_marca').text(getAttr('marca'));
                modal.find('#modal_tipo').text(getAttr('tipo'));
                modal.find('#modal_serial').text(getAttr('serial'));
                modal.find('#modal_so').text(getAttr('so'));

                // Asignación y Valor
                modal.find('#modal_usuario').text(getAttr('usuario'));
                modal.find('#modal_ubicacion').text(getAttr('ubicacion'));
                modal.find('#modal_valo_inicial').text(getAttr('valo-inicial'));
                modal.find('#modal_fecha_adquisicion').text(getAttr('fecha-adquisicion'));
                modal.find('#modal_vida_util').text(getAttr('vida-util'));

                // Componentes (Detalles)
                modal.find('#modal_monitores').text(getAttr('monitores'));
                modal.find('#modal_discos_duros').text(getAttr('discos-duros'));
                modal.find('#modal_ram').text(getAttr('ram'));
                modal.find('#modal_procesadores').text(getAttr('procesadores'));
                
                // Periféricos requiere un manejo especial por la lista de tipos
                let perifericos = getAttr('perifericos');
                modal.find('#modal_perifericos').text(perifericos || 'Ninguno');

            });
        });
    </script>
@stop