@extends('adminlte::page')

@section('title', 'Depreciación de Activos')

@section('css')
<style>
    .table-depreciacion thead th {
        background-color: #f8f9fa;
        color: #6c757d;
        font-weight: 700;
        border-bottom: 3px solid #6c757d;
        vertical-align: middle;
        padding: 10px;
    }

    .table-depreciacion tbody td {
        vertical-align: middle;
        font-size: 16px;
    }

    .secondary-data {
        color: #6c757d;
        font-size: 0.85em;
        display: block;
    }

    .valor-actual {
        font-weight: 700;
        color: #198754;
    }

    .valor-depreciado {
        color: #dc3545;
        font-weight: 600;
    }
</style>
@stop

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="mb-0">
            <i class="fas fa-chart-line text-secondary"></i> Depreciación de Activos
        </h1>
        <small class="text-muted">
            Análisis financiero y valor actual de activos TI
        </small>
    </div>

    <div>
        <a href="{{ route('depreciacion.pdf') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-file-pdf"></i> Exportar PDF
        </a>
    </div>
</div>
@stop


<div class="modal fade" id="modalDepreciacion" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-chart-line"></i> Depreciación en tiempo real
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    &times;
                </button>
            </div>

            <div class="modal-body">
                <p><strong>Activo: </strong><span id="d-activo"></span></p>
                <p><strong>Valor inicial:</strong> $<span id="d-valor"></span></p>
                <p><strong>Años transcurridos:</strong> <span id="d-añosTrasncurridos"></span></p>
                <p><strong>Depreciación acumulada:</strong> 
                    <span class="text-danger">$<span id="d-depreciado"></span></span>
                </p>
                <hr>
                <p class="h5">
                    <strong>Valor actual:</strong> 
                    <span class="text-success">$<span id="d-actual"></span></span>
                </p>
            </div>

        </div>
    </div>
</div>


@section('content')

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-depreciacion">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th><i class="fas fa-desktop"></i> Activo</th>
                        <th><i class="fas fa-user"></i> Usuario</th>
                        <th><i class="fas fa-map-marker-alt"></i> Ubicación</th>
                        <th><i class="fas fa-dollar-sign"></i> Valor Inicial</th>
                        <th><i class="fas fa-calendar-alt"></i> Fecha Adq.</th>
                        <th><i class="fas fa-hourglass-half"></i> Vida Útil</th>
                        <th class="text-center">
                        <i class="fas fa-bolt"></i>
                        Calcular Depreciacion
                        <i class="fas fa-chart-pie ml-1"></i>
                        </th>
                    </tr>
                </thead>

                <tbody>
                @forelse($equipos as $equipo)
                    <tr>
                        <td>{{ $equipo->id }}</td>

                        {{-- ACTIVO --}}
                        <td>
                            <strong>{{ $equipo->marca_equipo }}</strong>
                            <span class="secondary-data">
                                {{ $equipo->tipo_equipo }} · Serial: {{ $equipo->serial ?? 'N/A' }}
                            </span>
                        </td>

                        {{-- USUARIO --}}
                        <td>
                            {{ $equipo->usuario->name ?? 'Sin asignar' }}
                        </td>

                        {{-- UBICACIÓN --}}
                        <td>
                            {{ $equipo->ubicacion->nombre ?? 'Sin ubicación' }}
                        </td>

                        {{-- VALOR INICIAL --}}
                        <td>
                            ${{ number_format($equipo->valor_inicial, 2) }}
                        </td>

                        {{-- FECHA --}}
                        <td>
                            {{ \Carbon\Carbon::parse($equipo->fecha_adquisicion)->format('d/m/Y') }}
                        </td>

                        {{-- VIDA ÚTIL --}}
                        <td>
                            {{ $equipo->vida_util_estimada }}
                        </td>

                        <!-- BOTON PARA CALCULAR LA DEPRECIACION -->
                        <td class="text-center">
                            <button class="btn btn-outline-secondary btn-sm btn-depreciar"
                                data-marca="{{$equipo->marca_equipo}}"
                                data-valor="{{ $equipo->valor_inicial }}"
                                data-fecha="{{ $equipo->fecha_adquisicion }}"
                                data-vida="{{ $equipo->vida_util_estimada }}"
                                title="Calcular depreciación en tiempo real">
                                <i class="fas fa-search-dollar"></i>
                            </button>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">
                            No hay activos para calcular depreciación
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $equipos->links() }}
            </div>
        </div>
    </div>
</div>

@stop


@section('js')
    <script>

//Buscar el elemento que Actviva el JS
document.querySelectorAll('.btn-depreciar').forEach(btn => {
    btn.addEventListener('click', function () {

        //Tomamos el usuario actual
        const marca = this.dataset.marca;

        //Definimos las constantes de valor, fecha y vida
        const valor = parseFloat(this.dataset.valor);   //TOMAMOS EL VALOR INCIAL
        const fecha = new Date(this.dataset.fecha);     //Tomamos la fecha Inicial
        const vida = parseInt(this.dataset.vida); // AÑOS QUE INGRESO EL USUARIO

        //Tomamos la fecha de hoy
        const hoy = new Date();

        //CALULAMOS AÑOS TRANSCURRIDOS
        const añosTrasncurridos = Math.floor((hoy - fecha) / (1000 * 60 * 60 * 24 * 365));

        //Calulamos la depreciacion Anual
        const depreciacionAnual = valor / vida;

        //Tomamos el reciduoe de esa cosa
        const depreciado = Math.min(depreciacionAnual * añosTrasncurridos, valor);

        //Damos el actual
        const actual = valor - depreciado;

        //Insertamos estos datos en el modal
        document.getElementById('d-activo').innerText = marca;
        document.getElementById('d-valor').innerText = valor.toFixed(2);
        document.getElementById('d-añosTrasncurridos').innerText = añosTrasncurridos;
        document.getElementById('d-depreciado').innerText = depreciado.toFixed(2);
        document.getElementById('d-actual').innerText = actual.toFixed(2);

        //Abre el modal con las datos ya calculados
        $('#modalDepreciacion').modal('show');
    });
});
</script>

@stop