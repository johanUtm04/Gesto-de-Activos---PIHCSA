<?php

namespace App\Observers;
use App\Models\Monitor;
use App\Models\Historial_log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class MonitorObserver
{
    /**
     * Handle the Monitor "created" event.
     */
    public function created(Monitor $monitor): void
    {
        //
    }

    /**
     * Handle the Monitor "updated" event.
     */
    public function updated(Monitor $monitor): void
    {
        //

        // 1. Verificamos si hubo cambios reales ignorando la fecha de actualización
        if ($monitor->isDirty()) {
            $cambios = [];

            foreach ($monitor->getDirty() as $atributo => $nuevoValor) {
                if ($atributo === 'updated_at' || $atributo === 'equipo_id') continue;

                // 2. Creamos una etiqueta clara para el historial
                $campoLegible = "Monitor -> " . Str::headline($atributo);

                $cambios[$campoLegible] = [
                    'antes'   => $monitor->getOriginal($atributo),
                    'despues' => $nuevoValor
                ];
            }

            // 3. Solo creamos el log si el array de cambios no quedó vacío
            if (!empty($cambios)) {
                Historial_log::create([
                    'activo_id'         => $monitor->equipo_id, // Vinculamos al equipo padre
                    'usuario_accion_id' => Auth::id() ?? 1,
                    'tipo_registro'     => 'UPDATE',
                    'detalles_json'     => [
                        'mensaje'          => 'Se actualizó información del monitor',
                        'usuario_asignado' => $monitor->equipo->usuario->name ?? 'N/A',
                        'rol'              => $monitor->equipo->usuario->rol ?? 'N/A',
                        'cambios'          => $cambios
                    ]
                ]);
            }}
    }

    /**
     * Handle the Monitor "deleted" event.
     */
    public function deleted(Monitor $monitor): void
    {
        //
    }

    /**
     * Handle the Monitor "restored" event.
     */
    public function restored(Monitor $monitor): void
    {
        //
    }

    /**
     * Handle the Monitor "force deleted" event.
     */
    public function forceDeleted(Monitor $monitor): void
    {
        //
    }
}
