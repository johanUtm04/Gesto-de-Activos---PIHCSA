@extends('adminlte::page')

@section('title', 'Inventario de Activos TI')

@section('css')
<style>
    .table-assets thead th {
        background-color: #e9ecef; 
        color: #17a2b8; 
        font-weight: 900;
        border-bottom: 3px solid #17a2b8;
        vertical-align: middle;
        padding: 10px;
    }

    .table-assets tbody td {
        vertical-align: top; 
        font-size: 18px;
        line-height: 1.4;
    }

    .secondary-data {
        color: #6c757d; 
        font-size: 0.85em;
        display: block; 
    }

    .modal-detail-row {
        padding: 8px 0;
        border-bottom: 1px dashed #ced4da; 
    }

    .modal-detail-row:last-child {
        border-bottom: none;
    }
    
    .modal-header .close {
        padding: 1rem 1rem;
        margin: -1rem -1rem -1rem auto;
    }

    .table td .badge {
        font-weight: 500;
        padding: 6px 8px;
    }

</style>
@stop

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="mb-0">
            <i class="fas fa-boxes text-info"></i> Inventario de Activos
        </h1>
        <small class="text-muted">
            Rol actual:  <strong>{{ ucfirst(auth()->user()->rol) }}</strong> 
        </small>
    </div>

    <div class="btn-group">
        @can('crear-equipo')
        <a href="{{ route('equipos.wizard.create') }}" class="btn btn-info">
            <i class="fas fa-plus"></i> Agregar Equipo
        </a>
        @endcan
    </div>
</div>
@stop

@section('content')
    
    {{--(Alertas AdminLTE)--}}
    @php
        $alertTypes = ['success', 'danger', 'warning', 'info', 'primary'];
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
                            <th><i class="fas fa-user-tag"></i> Usuario</th>
                            <!-- <th><i class="fas fa-map-marker-alt"></i> Ubicación</th> -->
                            <!-- <th><i class="fas fa-dollar-sign"></i> Valor Inicial</th> -->
                            <!-- <th><i class="fas fa-puzzle-piece"></i>Componentes</th> -->
                            <th class="text-center"><i class="fas fa-cogs"></i> Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($equipos as $equipo)
                            <tr id="equipo-{{ $equipo->id }}">
                                <td>{{ $equipo->id }}</td>
                                
                                {{-- ACTIVO / SERIAL (Agrupado) --}}
                                <td>
                                    @if(session('new_id') == $equipo->id)
                                        <span class="badge badge-success ml-1">Nuevo</span>
                                    @endif
                                    @if(session('actualizado-id') == $equipo->id)
                                        <span class="badge badge-warning ml-1">Editado</span>
                                    @endif
                                    <strong>{{ $equipo->tipo_equipo }}-</strong>{{ $equipo->marca_equipo ?? '-' }}  <br>
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
                                <!-- <td>
                                    <strong>{{ $equipo->ubicacion->nombre ?? 'Sin ubicación' }}</strong>
                                    <br>
                                    <span class="secondary-data"><i class="fas fa-map-pin"></i> Código: {{ $equipo->ubicacion->codigo ?? '-' }}</span>
                                </td> -->

                                {{-- VALOR / FECHA --}}
                                <!-- <td>
                                    <strong class="text-success">${{ number_format($equipo->valor_inicial, 2) }}</strong><br>
                                    <span class="secondary-data">Adq: {{ $equipo->fecha_adquisicion }}</span><br>
                                    <span class="secondary-data">Vida Útil: {{ $equipo->vida_util_estimada }}</span>
                                </td> -->
                                
                                {{-- OTROS COMPONENTES (Resumen) --}}
                                <!-- <td>
                                    <span class="badge badge-light">
                                        <i class="fas fa-tv"></i> {{ $equipo->monitores->count() }}
                                    </span>

                                    <span class="badge badge-light ml-1">
                                        <i class="fas fa-hdd"></i> {{ $equipo->discosDuros->count() }}
                                    </span>

                                    <span class="badge badge-light ml-1">
                                        <i class="fas fa-memory"></i> {{ $equipo->rams->count() }}
                                    </span>

                                    <span class="badge badge-light ml-1">
                                        <i class="fas fa-keyboard"></i> {{ $equipo->perifericos->count() }}
                                    </span>
                                </td> -->

                                {{-- Acciones --}}
                                <td class="text-center">
                                    <div class="btn-group btn-group-lg" role="group">

                                        {{-- Botón Ver Detalles (Modal) --}}
                                        <button class="btn btn-outline-info" title="Ver detalles a profundidad"
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
                                        @can('editar-equipo')
                                        <a href="{{ route('equipos.edit', $equipo) }}" class="btn btn-outline-warning" title="Editar Activo">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        @endcan

                                        {{-- Botón Mantenimiento --}}
                                        @can('mantenimiento-equipo')
                                        <a href="{{ route('equipos.addwork.index', $equipo) }}" class="btn btn-outline-primary" title="Registrar Mantenimiento">
                                            <i class="fas fa-tools"></i>
                                        </a>
                                        @endcan
                        
                                        {{-- Botón Eliminar --}}
                                        @can('eliminar-equipo')
                                        <form action="{{ route('equipos.destroy', $equipo) }}" method="POST" style="display:inline-block;"  class="d-inline-flex">
                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-outline-danger btn-lg" title="Eliminar Activo"
                                                onclick="return confirm('¿Confirma la eliminación del equipo: {{ $equipo->marca_equipo }}? Esto eliminará todos sus componentes asociados.')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                           @endcan
                                    
                            
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $equipos->links() }}
                </div>
            </div> {{-- /table-responsive --}}
        </div> {{-- /card-body --}}
    </div> {{-- /card --}}

@stop


@section('footer')
<footer class="main-footer text-sm">
    <div class="float-right d-none d-sm-inline">
        <i class="fas fa-code"></i> PIHCSA · Gestion de Activos
    </div>

    <strong>
        <i class="fas fa-boxes"></i> Inventario de Activos TI
    </strong>
    &copy; {{ date('Y') }} |
    Desarrollado por <strong>Johan</strong>

</footer>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#modalDetalle').on('show.bs.modal', function (event) {
                const button = $(event.relatedTarget); 
                const modal = $(this);

                const getAttr = (attr) => button.data(attr);
                
                modal.find('.modal-title').text('Detalles del Activo: ' + getAttr('marca'));

                modal.find('#modal_id').text(getAttr('id'));
                modal.find('#modal_marca').text(getAttr('marca'));
                modal.find('#modal_tipo').text(getAttr('tipo'));
                modal.find('#modal_serial').text(getAttr('serial'));
                modal.find('#modal_so').text(getAttr('so'));

                modal.find('#modal_usuario').text(getAttr('usuario'));
                modal.find('#modal_ubicacion').text(getAttr('ubicacion'));
                modal.find('#modal_valo_inicial').text(getAttr('valo-inicial'));
                modal.find('#modal_fecha_adquisicion').text(getAttr('fecha-adquisicion'));
                modal.find('#modal_vida_util').text(getAttr('vida-util'));

                modal.find('#modal_monitores').text(getAttr('monitores'));
                modal.find('#modal_discos_duros').text(getAttr('discos-duros'));
                modal.find('#modal_ram').text(getAttr('ram'));
                modal.find('#modal_procesadores').text(getAttr('procesadores'));
                
                let perifericos = getAttr('perifericos');
                modal.find('#modal_perifericos').text(perifericos || 'Ninguno');

            });
        });

    document.addEventListener('DOMContentLoaded', function () {
        const id = "{{ session('new_id') ?? session('actualizado-id') }}";

        if (id) {
            const row = document.getElementById('equipo-' + id);
            if (row) {
                row.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });

    </script>
@stop