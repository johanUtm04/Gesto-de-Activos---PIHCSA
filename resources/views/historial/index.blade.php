{{-- ESTRUCTURA DE LA VISTA historial/index.blade.php --}}
@extends('adminlte::page')

@section('content')
<div class="container-fluid py-4">
    
    {{-- ENCABEZADO GLOBAL --}}
    <div class="row mb-4 align-items-end">
        <div class="col-md-6">
            <h3 class="text-dark font-weight-bold mb-0">
                <i class="fas fa-clipboard-check text-primary mr-2"></i> Auditoría de Activos
            </h3>
            <p class="text-muted small">Historial detallado de movimientos y cambios técnicos</p>
        </div>
    </div>

    @foreach($equipos as $equipo)
    <div class="card card-asset mb-4 shadow-sm border-0 transition-hover">
        
        {{-- HEADER DEL EQUIPO --}}
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 header-expandible" 
             style="cursor: pointer; border-left: 5px solid blue;" 
             data-toggle="collapse" 
             data-target="#collapseEquipo{{ $equipo->id }}">
            
            <div class="d-flex align-items-center">
                <div class="icon-box mr-3 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="fas {{ $equipo->tipo_equipo == 'Laptop' ? 'fa-laptop text-primary' : 'fa-desktop text-purple' }} fa-lg"></i>
                </div>
                <div>
                    <h6 class="mb-0 font-weight-bold text-dark text-uppercase">{{ $equipo->nombre_equipo }}</h6>
                    <div class="d-flex align-items-center">
                        <span class="badge badge-light border text-muted px-2 mr-2">ID: {{ $equipo->id }}</span>
                        <small class="text-muted">
                            <i class="fas fa-user-circle mr-1"></i> Custodio: <strong>{{ $equipo->usuario->name ?? 'Sin asignar' }}</strong>
                        </small>
                    </div>
                </div>
            </div>
            
            <div class="text-right">
                <span class="badge badge-pill badge-primary-soft px-3 mr-2">
                    {{ optional($equipo->historials)->count() ?? 0 }} Eventos Totales
                </span>
                <i class="fas fa-chevron-down text-muted transition-icon"></i>
            </div>
        </div>

        {{-- CUERPO COLAPSABLE --}}
        <div id="collapseEquipo{{ $equipo->id }}" class="collapse {{ request('equipo_id') == $equipo->id ? 'show' : '' }}">
            <div class="card-body bg-gray-50 p-0">
                
                {{-- FILTRO INTERNO POR CARD --}}
                <div class="px-4 py-3 bg-white border-bottom">
                    <form action="{{ route('historial.index') }}" method="GET" class="form-inline">
                        <input type="hidden" name="equipo_id" value="{{ $equipo->id }}">
                        <input type="hidden" name="page" value="{{ request('page', 1) }}">
                        <label class="mr-2 small font-weight-bold text-muted">Filtrar logs de este equipo:</label>
                        
                        <select name="tipo_registro" class="form-control form-control-sm mr-2">
                            <option value="">Todas las acciones</option>
                            <option value="CREATE" {{ (request('tipo_registro') == 'CREATE' && request('equipo_id') == $equipo->id) ? 'selected' : '' }}>Creación</option>
                            <option value="UPDATE" {{ (request('tipo_registro') == 'UPDATE' && request('equipo_id') == $equipo->id) ? 'selected' : '' }}>Actualización</option>
                            <option value="DELETE" {{ (request('tipo_registro') == 'DELETE' && request('equipo_id') == $equipo->id) ? 'selected' : '' }}>Eliminación</option>
                            <option value="MANTENIMIENTO" {{ (request('tipo_registro') == 'MANTENIMIENTO' && request('equipo_id') == $equipo->id) ? 'selected' : '' }}>MANTENIMIENTO</option>

                        </select>

                        <button type="submit" class="btn btn-primary btn-sm mr-1">
                            <i class="fas fa-filter fa-xs"></i>
                        </button>
                        <a href="{{ route('historial.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-undo fa-xs text-danger"></i>
                        </a>
                    </form>
                </div>

                {{-- LISTADO DE LOGS (TIMELINE) --}}
                <div class="p-4 scroll-custom" style="max-height: 500px; overflow-y: auto;">
                    <div class="timeline-v2">
                        @php
                            // Filtrado en memoria si se solicitó para este equipo específico
                            $logs = $equipo->historials()->latest();
                            if(request('equipo_id') == $equipo->id && request('tipo_registro')){
                                $logs->where('tipo_registro', request('tipo_registro'));
                            }
                            $logs = $logs->get();
                        @endphp

                        @forelse($logs as $log)
                            @php 
                                $colors = [
                                    'CREATE' => ['bg' => 'bg-success', 'soft' => 'success-soft'],
                                    'UPDATE' => ['bg' => 'bg-warning', 'soft' => 'warning-soft'],
                                    'DELETE' => ['bg' => 'bg-danger', 'soft' => 'danger-soft']
                                ][$log->tipo_registro] ?? ['bg' => 'bg-secondary', 'soft' => 'secondary-soft'];
                                $detalles = $log->detalles_json;
                            @endphp

                            <div class="log-card mb-4 bg-white shadow-xs rounded border transition-hover">
                                <div class="p-3 border-bottom d-flex justify-content-between align-items-center {{ $colors['soft'] }}">
                                    <div>
                                        <span class="badge {{ $colors['bg'] }} text-white px-3 py-1 mr-2">{{ $log->tipo_registro }}</span>
                                        <small class="font-weight-bold text-dark">{{ $log->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                </div>

                                <div class="p-3">
                                    @if(isset($detalles['cambios']))
                                        <div class="table-responsive">
                                            <table class="table table-sm table-borderless mb-0">
                                                @foreach($detalles['cambios'] as $campo => $valor)
                                                    <tr>
                                                        <td class="text-muted small font-weight-bold" style="width: 30%">{{ Str::headline($campo) }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span class="val-old">{{ $valor['antes'] ?? 'N/A' }}</span>
                                                                <i class="fas fa-arrow-right mx-2 text-muted small"></i>
                                                                <span class="val-new">{{!! $valor['despues'] ?? 'N/A' !!}}</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    @else
                                        <p class="mb-0 small text-muted">{{ $detalles['mensaje'] ?? 'Sin descripción' }}</p>
                                    @endif
                                </div>
                                <div class="p-2 px-3 bg-light border-top text-right">
                                    <small class="text-muted">Por: <strong>{{ $log->usuario->name ?? 'Sistema' }}</strong></small>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-muted small">No se encontraron logs con ese criterio.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <div class="mt-4 pb-5 d-flex justify-content-center">
        {!! $equipos->links() !!}
    </div>
</div>

<style>
    /* Estilos base */
    :root { --success-soft: #f0fff4; --warning-soft: #fffdf0; --danger-soft: #fff5f5; }
    .success-soft { background-color: var(--success-soft); }
    .warning-soft { background-color: var(--warning-soft); }
    .danger-soft { background-color: var(--danger-soft); }
    
    .val-old { text-decoration: line-through; color: #e53e3e; font-size: 0.8rem; background: #fff; padding: 2px 5px; border-radius: 3px; border: 1px solid #fed7d7; }
    .val-new { font-weight: bold; color: #38a169; font-size: 0.8rem; background: #fff; padding: 2px 5px; border-radius: 3px; border: 1px solid #c6f6d5; }

    /* Timeline */
    .timeline-v2 { position: relative; padding-left: 20px; border-left: 2px solid #e9ecef; }
    .log-card { position: relative; }
    .log-card::before {
        content: ''; position: absolute; left: -27px; top: 20px;
        width: 12px; height: 12px; background: #007bff; border-radius: 50%; border: 2px solid #fff;
    }

    .scroll-custom::-webkit-scrollbar { width: 5px; }
    .scroll-custom::-webkit-scrollbar-thumb { background: #cbd5e0; border-radius: 10px; }
    .transition-hover:hover { transform: translateY(-2px); transition: 0.2s; }
</style>
@endsection