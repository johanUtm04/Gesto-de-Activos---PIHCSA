@extends('adminlte::page')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4 text-dark"><i class="fas fa-history text-primary"></i> Auditoría General de Activos</h3>

    <h4 class="mb-4">
        <i class="fas fa-database text-info mr-2"></i> 
        Total de Activos: 
        <span class="badge badge-dark badge-pill px-3 py-2" style="font-size: 1.2rem;">
            {{$equipos->count()}}
        </span>
    </h4>
    @foreach($equipos as $equipo)
    <div class="card mb-3 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center" 
             style="cursor: pointer;" 
             data-toggle="collapse" 
             data-target="#collapseEquipo{{ $equipo->id }}">
            
             <div>
            <span class="badge badge-info mr-2">
                @if($equipo->tipo_equipo == 'Laptop')
                    <i class="fas fa-laptop"></i>
                @elseif($equipo->tipo_equipo == 'Desktop')
                    <i class="fas fa-desktop"></i>
                @else
                    <i class="fas fa-microchip"></i>
                @endif
                {{ $equipo->tipo_equipo }}
            </span>               
                <strong class="text-uppercase">{{ $equipo->nombre_equipo }}</strong>
                <span class="text-muted ml-3 small">| {{ $equipo->marca_equipo ?? 'Sin marca' }} - {{ $equipo->id ?? '' }}</span>
                 <span class="text-muted ml-3 small">| A cargo de: - <strong>{{ $equipo->usuario->name ?? '' }}</strong> </span>
            </div>
            
            <div>
                <span class="badge badge-pill badge-light border">
                    {{ $equipo->historials->count() }} Movimientos
                </span>
                <i class="fas fa-chevron-down ml-2 text-muted"></i>
            </div>
        </div>

    <!-- Dentro de cada tarjeta  (ENCABEZADO) -->
<div id="collapseEquipo{{ $equipo->id }}" class="collapse">
    <div class="card-body bg-light">
        <div class="timeline-container">
            <!-- Accedemos a la relacion de la base de datos, mostramos los mas recientes y los llammos get -->
            @forelse($equipo->historials()->latest()->get() as $log)
                @php                     
                    $badgeColor = ['CREATE'=>'success', 'UPDATE'=>'warning', 'DELETE'=>'danger'][$log->tipo_registro] ?? 'secondary';
                    $detalles = $log->detalles_json;

                    DD($detalles);
                @endphp

                <div class="timeline-entry p-3 rounded shadow-sm">
                    <!-- Parte del encabezado -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <span class="badge badge-{{ $badgeColor }} mr-2">{{ $log->tipo_registro }}</span>
                            <small class="text-dark font-weight-bold">
                                <i class="fas fa-user-edit text-muted"></i> {{ $log->usuario->name ?? 'Sistema' }}
                            </small>
                        </div>
                        <small class="text-muted"><i class="far fa-clock"></i> {{ $log->created_at->format('d/m/Y H:i') }} ({{ $log->created_at->diffForHumans() }})</small>
                    </div>

                    <!-- Cajita de datos -->
                    <div class="bg-light p-2 rounded border-left border-info">
                        <span class="small text-muted d-block mb-1">Usuario que maneja el Activo En esta Operacion: <strong>{{ $detalles['usuario_asignado'] ?? 'N/A' }}</strong></span>
                        <span class="small text-muted d-block mb-1">Rol: <strong>{{ $detalles['rol'] ?? 'N/A' }}</strong></span>
                        <!-- SI ES UNA ACTUALIZACION -->
                        @if($log->tipo_registro == 'UPDATE' && isset($detalles['cambios']))
                            <div class="table-responsive">
                                <table class="table table-sm table-borderless mb-0" style="font-size: 0.85rem;">
                                    @foreach($detalles['cambios'] as $campo => $valor)
                                        <tr>
                                            <td class="py-0 font-weight-bold" style="width: 30%;">{{ ucfirst(str_replace('_', ' ', $campo)) }}:</td>
                                            <td class="py-0">
                                            <span class="text-danger font-italic">
                                                {{ $valor['antes'] ?? '(sin datos)' }}
                                            </span> 
                                            <i class="fas fa-long-arrow-alt-right mx-2 text-muted"></i> 
                                            <span class="text-success font-weight-bold">
                                                {{ $valor['despues'] ?? '(sin datos)' }}
                                            </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        @else
                        <p class="mb-0 small d-flex align-items-start">
                            <i class="fas fa-info-circle text-primary mt-1 mr-2"></i>
                            <span>
                                <span class="text-muted font-weight-bold">Evento:</span> 
                                <span class="text-dark">{{ $detalles['mensaje'] ?? 'Actividad registrada en el sistema.' }}</span>
                            </span>
                        </p>                        
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-center text-muted small my-3">Este equipo aún no registra movimientos de auditoría.</p>
            @endforelse
        </div>
    </div>
</div>
    </div>
    @endforeach
    @if($equipos->hasPages())
    <div class="card-footer bg-white border-top-0">
        {{ $equipos->links() }}
    </div>
    @endif
</div>

<style>
    .timeline-entry { 
        position: relative; 
        background: white; 
        border: 1px solid #e3e6f0; 
        margin-bottom: 15px;
    }


    .timeline-entry::before {
        content: '';
        position: absolute;
        left: -17px;
        top: 12px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid #007bff;
        z-index: 1;
    }

    .timeline-container { position: relative; padding-left: 20px; }
    .timeline-container::before {
        content: '';
        position: absolute;
        left: 7px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }
    .timeline-entry { 
        position: relative; 
        background: white; 
        border: 1px solid #e3e6f0; 
        margin-bottom: 15px;
    }
</style>
@endsection