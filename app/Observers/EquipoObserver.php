<?php

namespace App\Observers;

use App\Models\Equipo;
use App\Services\AuditService;

class EquipoObserver
{
    /**
     * Handle the Equipo "created" event.
     */
    public function created(Equipo $equipo): void
    {
        AuditService::log(
            'EQUIPO_CREADO',
            $equipo->id,
            [
                'mensaje' => 'Se creó un equipo',
                'despues' => $equipo->toArray()
            ]
        );
    }

    /**
     * Handle the Equipo "updated" event.
     */
    public function updated(Equipo $equipo): void
    {
        AuditService::log(
            'EQUIPO_ACTUALIZADO',
            $equipo->id,
            [
                'mensaje' => 'Se actualizó un equipo',
                'antes' => $equipo->getOriginal(),
                'despues' => $equipo->getAttributes()
            ]
        );
    }

    /**
     * Handle the Equipo "deleted" event.
     */
    public function deleted(Equipo $equipo): void
    {
        AuditService::log(
            'EQUIPO_ELIMINADO',
            $equipo->id,
            [
                'mensaje' => 'Se eliminó un equipo',
                'antes' => $equipo->getOriginal()
            ]
        );
    }

    /**
     * Handle the Equipo "restored" event.
     */
    public function restored(Equipo $equipo): void
    {
        AuditService::log(
            'EQUIPO_RESTAURADO',
            $equipo->id,
            [
                'mensaje' => 'Se restauró un equipo',
                'despues' => $equipo->toArray()
            ]
        );
    }

    /**
     * Handle the Equipo "force deleted" event.
     */
    public function forceDeleted(Equipo $equipo): void
    {
        AuditService::log(
            'EQUIPO_ELIMINACION_PERMANENTE',
            $equipo->id,
            [
                'mensaje' => 'Se eliminó permanentemente un equipo',
                'antes' => $equipo->getOriginal()
            ]
        );
    }
}
