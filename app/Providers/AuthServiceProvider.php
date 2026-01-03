<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;


// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    public function boot(): void
    {
    // Ver equipos (todos)
    Gate::define('ver-equipo', function ($user) {
        return true;
    });

    // Crear equipo (admin + sistemas)
    Gate::define('crear-equipo', function ($user) {
        return in_array( strtolower($user->rol), ['admin', '']);
    });

    // Editar equipo (admin + sistemas)
    Gate::define('editar-equipo', function ($user) {
        return in_array(strtolower($user->rol), ['admin', 'sistemas']);
    });

    // Eliminar equipo (solo admin)
    Gate::define('eliminar-equipo', function ($user) {
       return in_array(strtolower($user->rol), ['admin', 'sistemas']);
    });

    // Agregar mantenimiento a un equipo (solo admin)
    Gate::define('mantenimiento-equipo', function ($user) {
        return in_array(strtolower($user->rol), ['admin', 'sistemas']);
    });
    }
}
