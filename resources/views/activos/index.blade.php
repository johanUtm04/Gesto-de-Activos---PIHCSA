@extends('adminlte::page')

@section('title', 'Activos de la empresa')

@section('content_header')
<h1>Lista de activos</h1>
<a href="{{ route('activos.create') }}" class="btn btn-success mb-2">Agregar activo</a>
@stop

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Equipo</th>
            <th>Ram</th>
                        <th>Disco(s)Duros</th>
                                    <th>Monitores</th>
                                                <th>Perfifericos</th>
                                                            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
{{-- +--------------------+---------------------+------+-----+---------+----------------+
| Field              | Type                | Null | Key | Default | Extra          |
+--------------------+---------------------+------+-----+---------+----------------+
| id                 | bigint(20) unsigned | NO   | PRI | NULL    | auto_increment |
| marca_equipo       | varchar(255)        | YES  |     | NULL    |                |
| tipo_equipo        | varchar(255)        | NO   |     | NULL    |                |
| serial             | varchar(255)        | NO   |     | NULL    |                |
| sistema_operativo  | varchar(11)         | NO   |     | NULL    |                |
| usuario_id         | bigint(20) unsigned | NO   | MUL | NULL    |                |
| ubicacion_id       | bigint(20) unsigned | NO   | MUL | NULL    |                |
| valor_inicial      | decimal(8,2)        | NO   |     | NULL    |                |
| fecha_adquisicion  | date                | NO   |     | NULL    |                |
| vida_util_estimada | varchar(255)        | NO   |     | NULL    |                |
| created_at         | timestamp           | YES  |     | NULL    |                |
| updated_at         | timestamp           | YES  |     | NULL    |                |
+--------------------+---------------------+------+-----+---------+----------------+ --}}
        @foreach($activos as $activo)
        <tr>
            <td>{{ $activo->id }}</td>
            <td>{{ $activo->nombre }}</td>
            <td>{{ $activo->descripcion }}</td>
            <td>
                <a href="{{ route('activos.edit', $activo) }}" class="btn btn-primary btn-sm">Editar</a>
                <form action="{{ route('activos.destroy', $activo) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop
