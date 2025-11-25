@extends('adminlte::page')

@section('content')
    <div class="container">

        <h2>Equipo creado exitosamente</h2>
        <p>Marca: {{ $equipo->marca_equipo }}</p>
        <p>Tipo: {{ $equipo->tipo_equipo }}</p>

        <hr>

        <h3>Agregar información opcional</h3>

        <div class="list-group">

            <a href="{{ route('equipos.wizard.ubicacion', $equipo) }}" class="list-group-item">
                Registrar Ubicación
            </a>

            <a href="{{ route('equipos.wizard.monitores', $equipo) }}" class="list-group-item">
                Registrar Monitor
            </a>
            

        </div>

        <br>


        
    </div>
@endsection
