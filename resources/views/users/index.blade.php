@extends('adminlte::page')

@section('title', 'Gestión de Usuarios')

@section('css')
<style>
    .table-users thead th {
        background-color: #e9f7ef;
        color: #198754;
        font-weight: 900;
        border-bottom: 3px solid #198754;
        vertical-align: middle;
        padding: 10px;
    }

    .table-users tbody td {
        vertical-align: top;
        font-size: 17px;
        line-height: 1.4;
    }

    .secondary-data {
        color: #6c757d;
        font-size: 0.85em;
        display: block;
    }
</style>
@stop


@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="mb-0">
            <i class="fas fa-users text-success"></i> Gestión de Usuarios
        </h1>
        <small class="text-muted">
            Control, estado y administración de cuentas
        </small>
    </div>


    <div class="btn-group">
        <a href="{{ route('users.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Agregar Usuario
        </a>
    </div>
    
</div>
@stop


@section('content')

{{-- Alertas AdminLTE --}}
@php
    $alertTypes = ['success', 'danger', 'warning', 'info', 'primary'];
@endphp

@foreach ($alertTypes as $msg)
    @if(Session::has($msg))
        <div class="alert alert-{{ $msg }} alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            {{ Session::get($msg) }}
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
@endforeach


<div class="card">
    <div class="card-body">
        <div class="table-responsive">

            <table class="table table-bordered table-hover table-users">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th><i class="fas fa-user"></i> Usuario</th>
                        <th><i class="fas fa-user-shield"></i> Rol</th>
                        <th><i class="fas fa-building"></i> Departamento</th>
                        <th><i class="fas fa-toggle-on"></i> Estatus</th>
                        <th class="text-center"><i class="fas fa-cogs"></i> Acciones</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>

                        {{-- USUARIO --}}
                        <td>
                            <strong>{{ $user->name }}</strong>
                            <span class="secondary-data">
                                <i class="fas fa-envelope"></i> {{ $user->email }}
                            </span>
                        </td>

                        {{-- ROL (SIN BADGE) --}}
                        <td>
                            <i class="fas fa-user-shield text-muted"></i>
                            {{ $user->rol }}
                        </td>

                        {{-- DEPARTAMENTO --}}
                        <td>
                            <i class="fas fa-building text-muted"></i>
                            {{ $user->departamento }}
                        </td>

                        {{-- ESTATUS (SIN BADGE) --}}
                        <td>
                            @if($user->estatus === 'ACTIVO')
                                <i class="fas fa-check-circle text-success"></i>
                                Activo
                            @elseif($user->estatus === 'INACTIVO')
                                <i class="fas fa-times-circle text-danger"></i>
                                Inactivo
                            @else
                                <i class="fas fa-pause-circle text-warning"></i>
                                Suspendido
                            @endif
                        </td>

                        {{-- ACCIONES --}}
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('users.edit', $user) }}"
                                   class="btn btn-outline-success"
                                   title="Editar Usuario">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <form action="{{ route('users.destroy', $user) }}"
                                      method="POST"
                                      style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger"
                                            title="Eliminar Usuario"
                                            onclick="return confirm('¿Eliminar al usuario {{ $user->name }}?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{-- PAGINACIÓN --}}
            <div class="mt-3">
                {{ $users->links() }}
            </div>

        </div>
    </div>
</div>
@endsection

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