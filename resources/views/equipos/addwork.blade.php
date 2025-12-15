@extends('adminlte::page')

@section('title', 'Mantenimiento de Activo')

@section('css')
<style>
    .maintenance-card {
        background: #ffffffff;
        border-radius: 12px;
        padding: 25px;
        color: #000000ff;
        box-shadow: 0 0 15px rgba(0,0,0,.6);
    }

    .maintenance-card label {
        font-weight: 700;
        letter-spacing: .5px;
        margin-top: 15px;
    }

    .maintenance-card .form-control,
    .maintenance-card .custom-select {
        background: transparent;
        border: 2px solid #fff;
        color: #000000ff;
        border-radius: 8px;
    }

    .maintenance-card .form-control::placeholder {
        color: #ccc;
    }

    .maintenance-card .btn-register {
        margin-top: 25px;
        background: #007bff;
        border: none;
        padding: 10px 30px;
        border-radius: 8px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .maintenance-title {
        font-size: 1.3rem;
        font-weight: 800;
        margin-bottom: 20px;
    }
</style>
@stop

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="maintenance-card">

                <div class="maintenance-title">
                    Mantenimiento de {{ $equipo->marca_equipo ?? '[Nombre_Activo]' }}
                </div>


                <!-- <form action="{{ route('equipos.update', $equipo) }}" method="POST"> -->

                <form method="POST" action="{{ route('equipos.addwork.store', $equipo) }}">
                    @csrf

                    <label>TIPO EVENTO</label>
                    <select class="custom-select" name="tipo_evento">
                        <option value="">Seleccione una opción</option>
                        <option>Mantenimiento preventivo</option>
                        <option>Mantenimiento correctivo</option>
                        <option>Actualización</option>
                    </select>

                    <label>FECHA EVENTO</label>
                    <input type="date" class="form-control" name="fecha_evento">

                    <label>CONTEXTO DEL EVENTO</label>
                    <textarea class="form-control" rows="4" name="contexto" placeholder="Descripción del mantenimiento..."></textarea>

                    <label>COSTO (de tenerlo)</label>
                    <input type="number" step="0.01" class="form-control" name="costo" placeholder="$0.00">

                    <div class="text-center">
                        <button type="submit" class="btn btn-register">REGISTRAR</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@stop
