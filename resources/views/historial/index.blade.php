@extends('adminlte::page')

@section('content')
<div class="container-fluid py-4">
    
    <div class="row mb-4 align-items-end">
        <div class="col-md-4">
            <h3 class="text-dark font-weight-bold mb-0">
                <i class="fas fa-clipboard-check text-primary mr-2"></i> Auditoría de Activos
            </h3>
            <p class="text-muted small">Historial detallado de movimientos y cambios técnicos</p>
        </div>
        <!-- <div class="col-md-8">
            <form action="{{ route('historial.index') }}" method="GET" class="row no-gutters shadow-sm rounded p-2 bg-white border">
                <div class="col-md-4 px-1">
                    <label class="small font-weight-bold mb-1 text-muted">Tipo de Acción</label>
                    <select name="accion" class="form-control form-control-sm border-0 bg-light">
                        <option value="">Todas las acciones</option>
                        <option value="CREATE">Creación (CREATE)</option>
                        <option value="UPDATE">Modificación (UPDATE)</option>
                        <option value="DELETE">Eliminación (DELETE)</option>
                    </select>
                </div>
                <div class="col-md-4 px-1 border-left">
                    <label class="small font-weight-bold mb-1 text-muted">Rango de Fecha</label>
                    <input type="date" name="fecha" class="form-control form-control-sm border-0 bg-light">
                </div>
                <div class="col-md-4 px-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-sm btn-block shadow-sm">
                        <i class="fas fa-filter mr-1"></i> Filtrar Auditoría
                    </button>
                </div>
            </form>
        </div> -->
    </div>

    @foreach($equipos as $equipo)
    <div class="card card-asset mb-3 shadow-sm border-0 transition-hover">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 header-expandible" 
             style="cursor: pointer; border-left: 5px solid" {{ $equipo->tipo_equipo == 'Laptop' ? '#007bff' : '#6f42c1' }};" 
             data-toggle="collapse" 
             data-target="#collapseEquipo{{ $equipo->id }}">
            
            <div class="d-flex align-items-center">
                <div class="icon-box mr-3 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="fas {{ $equipo->tipo_equipo == 'Laptop' ? 'fa-laptop text-primary' : 'fa-desktop text-purple' }} fa-lg"></i>
                </div>
                <div>
                    <h6 class="mb-0 font-weight-bold text-dark text-uppercase">
                    {{ $equipo->nombre_equipo }}
                    </h6>
                    <div class="d-flex align-items-center">
                        <span class="badge badge-light border text-muted px-2 mr-2">ID: {{ $equipo->id }}</span>
                        <small class="text-muted"><i class="fas fa-user-circle mr-1"></i> Custodio: <strong>{{ $equipo->usuario->name ?? 'N/A' }}</strong></small>
                    </div>
                </div>
            </div>
            
            <div class="text-right">
                <span class="badge badge-pill badge-primary-soft px-3 mr-2">
                    {{ $equipo->historials->count() }} Eventos
                </span>
                <i class="fas fa-chevron-down text-muted transition-icon"></i>
            </div>
        </div>

        <div id="collapseEquipo{{ $equipo->id }}" class="collapse">
            <div class="card-body bg-gray-50 p-4 scroll-custom" style="max-height: 550px; overflow-y: auto;">
                <div class="timeline-v2">
                    @forelse($equipo->historials()->latest()->get() as $log)
                        @php 
                            $colors = [
                                'CREATE' => ['bg' => 'bg-success', 'border' => 'border-success', 'soft' => 'success-soft'],
                                'UPDATE' => ['bg' => 'bg-warning', 'border' => 'border-warning', 'soft' => 'warning-soft'],
                                'DELETE' => ['bg' => 'bg-danger', 'border' => 'border-danger', 'soft' => 'danger-soft']
                            ][$log->tipo_registro] ?? ['bg' => 'bg-secondary', 'border' => 'border-secondary', 'soft' => 'secondary-soft'];
                            $detalles = $log->detalles_json;
                        @endphp

                        <div class="log-card mb-4 bg-white shadow-xs rounded border transition-hover">
                            <div class="p-3 border-bottom d-flex justify-content-between align-items-center {{ $colors['soft'] }}">
                                <div>
                                    <span class="badge {{ $colors['bg'] }} text-white px-3 py-1 mr-2 shadow-sm">{{ $log->tipo_registro }}</span>
                                    <small class="font-weight-bold text-dark"><i class="far fa-calendar-check mr-1"></i> {{ $log->created_at->format('d/m/Y') }}</small>
                                    <span class="mx-2 text-muted">|</span>
                                    <small class="text-muted font-weight-bold"><i class="far fa-clock mr-1"></i> {{ $log->created_at->format('H:i:s') }}</small>
                                </div>
                                <span class="badge badge-white border text-muted small shadow-xs">{{ $log->created_at->diffForHumans() }}</span>
                            </div>

                            <div class="p-4">
                                <div class="row mb-3">
                                    <div class="col-sm-6 border-right">
                                        <label class="text-xs text-uppercase text-muted font-weight-bold mb-1 d-block">Usuario Asignado</label>
                                        <p class="mb-0 font-weight-bold text-dark"><i class="fas fa-user-tag text-primary mr-2"></i> {{ $detalles['usuario_asignado'] ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-sm-6 pl-4">
                                        <label class="text-xs text-uppercase text-muted font-weight-bold mb-1 d-block">Departamento / Rol</label>
                                        <p class="mb-0 text-muted"><i class="fas fa-briefcase mr-2"></i> {{ $detalles['rol'] ?? 'N/A' }}</p>
                                    </div>
                                </div>

                            @if($log->tipo_registro == 'UPDATE' || isset($detalles['cambios']))
                                <div class="table-responsive rounded border bg-light p-2">
                                    <table class="table table-sm table-borderless mb-0">
                                        <tbody> {{-- <-- Aquí empieza la tabla --}}
                                            
                                            {{-- REEMPLAZA DESDE AQUÍ --}}
                                            @foreach($detalles['cambios'] as $campo => $valor)
                                                <tr>
                                                    <td class="text-muted font-weight-bold small py-2" style="width: 25%;">
                                                        {{ Str::headline($campo) }}
                                                    </td>
                                                    <td class="py-2">
                                                        <div class="d-flex align-items-center">
                                                            {{-- Operador ternario: (Condición) ? si_verdadero : si_falso --}}
                                                            <span class="val-old shadow-xs">
                                                                {{ (isset($valor['antes']) && $valor['antes'] !== '') ? $valor['antes'] : 'Inexistente' }}
                                                            </span>

                                                            <i class="fas fa-long-arrow-alt-right mx-3 text-primary opacity-50"></i>

                                                            <span class="val-new shadow-xs">
                                                                {!! (isset($valor['despues']) && $valor['despues'] !== '') ? $valor['despues'] : 'Sin datos' !!}
                                                            </span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            {{-- HASTA AQUÍ --}}

                                        </tbody>
                                    </table>
                                </div>
                                @else
                                    <div class="info-msg p-3 rounded">
                                        <i class="fas fa-info-circle text-primary mr-2"></i> <strong>Nota:</strong> {{ $detalles['mensaje'] ?? 'Sin descripción adicional' }}
                                    </div>
                                @endif
                            </div>

                            <div class="p-2 px-4 bg-light border-top d-flex justify-content-end align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-signature mr-1 text-primary"></i> Registrado por: 
                                    <span class="text-dark font-weight-bold text-uppercase" style="letter-spacing: 0.5px;">{{ $log->usuario->name ?? 'Sistema' }}</span>
                                </small>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-database fa-3x text-light mb-3"></i>
                            <h5 class="text-muted">No hay registros de auditoría</h5>
                        </div>
                    @endforelse
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
    /* TEORÍA DEL COLOR Y UI */
    :root {
        --primary-soft: #e7f1ff;
        --success-soft: #f0fff4;
        --warning-soft: #fffdf0;
        --danger-soft: #fff5f5;
        --purple: #6f42c1;
    }

    .bg-gray-50 { background-color: #f9fafb; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    
    /* Clases de Soft Colors para los Headers de Log */
    .success-soft { background-color: var(--success-soft); border-bottom: 1px solid #c6f6d5 !important; }
    .warning-soft { background-color: var(--warning-soft); border-bottom: 1px solid #fef3c7 !important; }
    .danger-soft { background-color: var(--danger-soft); border-bottom: 1px solid #fed7d7 !important; }
    .badge-primary-soft { background: var(--primary-soft); color: #007bff; border: 1px solid #b3d7ff; }

    /* HOVERS Y TRANSICIONES */
    .transition-hover { transition: all 0.3s cubic-bezier(.25,.8,.25,1); }
    .card-asset:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .log-card:hover {
        border-color: #007bff !important;
        transform: scale(1.005);
    }

    /* COMPARACIÓN DE DATOS */
    .val-old { 
        text-decoration: line-through; 
        color: #e53e3e; 
        background: #fff; 
        padding: 3px 8px; 
        border: 1px solid #feb2b2;
        border-radius: 4px;
        font-size: 0.85rem;
    }
    .val-new { 
        font-weight: bold; 
        color: #38a169; 
        background: #fff; 
        padding: 3px 8px; 
        border: 1px solid #9ae6b4;
        border-radius: 4px;
        font-size: 0.85rem;
    }

    /* SCROLL PERSONALIZADO */
    .scroll-custom::-webkit-scrollbar { width: 6px; }
    .scroll-custom::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
    .scroll-custom::-webkit-scrollbar-thumb:hover { background: #9ca3af; }

    /* TIMELINE V2 */
    .timeline-v2 { position: relative; padding-left: 15px; border-left: 3px solid #e5e7eb; }
    .log-card::before {
        content: '';
        position: absolute;
        left: -23px;
        top: 25px;
        width: 14px;
        height: 14px;
        background: #007bff;
        border: 3px solid #fff;
        border-radius: 50%;
        box-shadow: 0 0 0 3px rgba(0,123,255,0.2);
    }

    .info-msg { background: #eff6ff; border-left: 4px solid #3b82f6; color: #1e40af; font-size: 0.9rem; }
    .transition-icon { transition: transform 0.3s; }
    .header-expandible[aria-expanded="true"] .transition-icon { transform: rotate(180deg); color: #007bff !important; }
    .text-purple { color: var(--purple); }
</style>
@endsection