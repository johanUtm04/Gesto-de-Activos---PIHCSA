@extends('adminlte::page')

@section('title', 'Editar Equipo')

@section('content_header')
<h1 class="text-center font-weight-bold">
    EDITAR DATOS DE {{ strtoupper($equipo->marca_equipo) }}
</h1>

<a href="{{ route('equipos.index') }}" class="btn btn-secondary mt-2">Volver</a>
@stop


@section('content')
<div class="container mt-4">

    <div class="row">

        {{-- LEFT SIDE – CURRENT DATA --}}
        <div class="col-md-6">
            <div class="card p-3" style="background:#0f0f0f; color:white; border:1px solid #333;">
                <h4 class="mb-3 text-info">Datos Actuales</h4>

                <p><strong>Nombre:</strong><br> {{ $equipo->marca_equipo }}</p>
                <hr>

                <p><strong>Tipo:</strong><br> {{ $equipo->tipo_equipo }}</p>
                <hr>

                <p><strong>Serial:</strong><br> {{ $equipo->serial }}</p>
                <hr>

                <p><strong>Sistema Operativo:</strong><br> {{ $equipo->sistema_operativo }}</p>
                <hr>

                <p><strong>Usuario Responsable:</strong><br> {{ $equipo->usuario->name ?? '-' }}</p>
                <hr>

                <p><strong>Ubicación:</strong><br> {{ $equipo->ubicacion->nombre ?? '-' }}</p>
                <hr>

                <p><strong>Valor Inicial:</strong><br> ${{ number_format($equipo->valor_inicial, 2) }}</p>
                <hr>

                <p><strong>Fecha de Adquisición:</strong><br> {{ $equipo->fecha_adquisicion }}</p>
                <hr>

                <p><strong>Vida Útil Estimada:</strong><br> {{ $equipo->vida_util_estimada }}</p>
            </div>
        </div>

        {{-- RIGHT SIDE – FORM TO UPDATE DATA --}}
        <div class="col-md-6">
            <div class="card p-3" style="background:#ffffff; border:1px solid #ccc;">
                <h4 class="mb-3 text-primary">Datos Modificados</h4>

                <form action="{{ route('equipos.update', $equipo) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Marca del Equipo</label>
                        <input type="text" name="marca_equipo" class="form-control"
                               value="{{ old('marca_equipo', $equipo->marca_equipo) }}">
                    </div>

                    <div class="form-group">
                        <label>Tipo de Equipo</label>
                        <input type="text" name="tipo_equipo" class="form-control"
                               value="{{ old('tipo_equipo', $equipo->tipo_equipo) }}">
                    </div>

                    <div class="form-group">
                        <label>Serial</label>
                        <input type="text" name="serial" class="form-control"
                               value="{{ old('serial', $equipo->serial) }}">
                    </div>

                    <div class="form-group">
                        <label>Sistema Operativo</label>
                        <input type="text" name="sistema_operativo" class="form-control"
                               value="{{ old('sistema_operativo', $equipo->sistema_operativo) }}">
                    </div>

                    <div class="form-group">
                        <label>Usuario Responsable</label>
                        <select name="usuario_id" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}"
                                {{ $equipo->usuario_id == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Ubicación</label>
                        <select name="ubicacion_id" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach($ubicaciones as $ubicacion)
                            <option value="{{ $ubicacion->id }}"
                                {{ $equipo->ubicacion_id == $ubicacion->id ? 'selected' : '' }}>
                                {{ $ubicacion->nombre }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Valor Inicial</label>
                        <input type="number" name="valor_inicial" class="form-control" step="0.01"
                               value="{{ old('valor_inicial', $equipo->valor_inicial) }}">
                    </div>

                    <div class="form-group">
                        <label>Fecha de Adquisición</label>
                        <input type="date" name="fecha_adquisicion" class="form-control"
                               value="{{ old('fecha_adquisicion', $equipo->fecha_adquisicion) }}">
                    </div>

                    <div class="form-group">
                        <label>Vida Útil Estimada</label>
                        <input type="text" name="vida_util_estimada" class="form-control"
                               value="{{ old('vida_util_estimada', $equipo->vida_util_estimada) }}">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block mt-3">
                        Guardar Cambios
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
