@extends('adminlte::page')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4 text-dark"><i class="fas fa-history text-primary"></i> Auditoría General de Activos</h3>

    <h3>Lista de Equipos de la empresa</h3>
    @foreach($equipos as $equipo)
    <div class="card mb-3 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center" 
             style="cursor: pointer;" 
             data-toggle="collapse" 
             data-target="#collapseEquipo{{ $equipo->id }}">
            
            <div>
                <span class="badge badge-info mr-2">{{ $equipo->tipo_equipo }}</span>
                <strong class="text-uppercase">{{ $equipo->nombre_equipo }}</strong>
                <span class="text-muted ml-3 small">| {{ $equipo->marca ?? 'Sin marca' }} - {{ $equipo->modelo ?? 'Sin modelo' }}</span>
            </div>
            
            <div>
                <span class="badge badge-pill badge-light border">
                    {{ $equipo->historials->count() }} Movimientos
                </span>
                <i class="fas fa-chevron-down ml-2 text-muted"></i>
            </div>
        </div>

<div id="collapseEquipo{{ $equipo->id }}" class="collapse">
    <div class="card-body bg-light">
        <div class="timeline-container">
            @forelse($equipo->historials()->latest()->get() as $log)
                @php                     
                    // Color del badge principal
                    $badgeColor = ['CREATE'=>'success', 'UPDATE'=>'warning', 'DELETE'=>'danger'][$log->tipo_registro] ?? 'secondary';
                    $detalles = $log->detalles_json;
                @endphp

                <div class="timeline-entry p-3 rounded shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <span class="badge badge-{{ $badgeColor }} mr-2">{{ $log->tipo_registro }}</span>
                            <small class="text-dark font-weight-bold">
                                <i class="fas fa-user-edit text-muted"></i> {{ $log->usuario->name ?? 'Sistema' }}
                            </small>
                        </div>
                        <small class="text-muted"><i class="far fa-clock"></i> {{ $log->created_at->format('d/m/Y H:i') }} ({{ $log->created_at->diffForHumans() }})</small>
                    </div>

                    <div class="bg-light p-2 rounded border-left border-info">
                        <span class="small text-muted d-block mb-1">Usuario asignado en este momento: <strong>{{ $detalles['usuario_asignado'] ?? 'N/A' }}</strong></span>
                        
                        @if($log->tipo_registro == 'UPDATE' && isset($detalles['cambios']))
                            <div class="table-responsive">
                                <table class="table table-sm table-borderless mb-0" style="font-size: 0.85rem;">
                                    @foreach($detalles['cambios'] as $campo => $valor)
                                        <tr>
                                            <td class="py-0 font-weight-bold" style="width: 30%;">{{ ucfirst(str_replace('_', ' ', $campo)) }}:</td>
                                            <td class="py-0">
                                                <span class="text-danger"><del>{{ $valor['antes'] ?? 'vacio' }}</del></span>
                                                <i class="fas fa-long-arrow-alt-right mx-1 text-muted"></i>
                                                <span class="text-success">{{ $valor['despues'] ?? 'vacio' }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        @else
                            <p class="mb-0 small">{{ $detalles['mensaje'] ?? 'Registro de actividad generado.' }}</p>
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