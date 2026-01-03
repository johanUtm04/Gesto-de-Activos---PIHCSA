<?php

namespace App\Observers;

use App\Models\DiscoDuro;
use App\Models\Historial_log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class DiscoDuroObserver
{
    /**
     * Handle the DiscoDuro "created" event.
     */
public function created(DiscoDuro $disco): void
    {
        // Accedemos a la relación del equipo (ajusta según tu modelo)
        $equipo = $disco->equipos; 

        if ($equipo) {
            Historial_log::create([
                'activo_id'         => $equipo->id,
                'usuario_accion_id' => Auth::id() ?? 1,
                'tipo_registro'     => 'CREATE', 
                'detalles_json'     => [
                    'mensaje'          => 'NUEVO COMPONENTE: Se instaló una unidad de almacenamiento',
                    'usuario_asignado' => $equipo->usuario->name ?? 'N/A',
                    'rol'              => $equipo->usuario->rol ?? 'N/A',
                    'cambios'          => [
                        'Disco Duro / SSD' => [
                            'antes'   => 'Inexistente',
                            'despues' => "<ul class='list-unstyled mb-0'>" .
                                         "<li><b>Capacidad:</b> {$disco->capacidad}</li>" .
                                         "<li><b>Tipo:</b> {$disco->tipo_hdd_ssd}</li>" .
                                         "<li><b>Interface:</b> {$disco->interface}</li>" .
                                         "</ul>"
                        ]
                    ]
                ]
            ]);
        }
    }

    /**
     * Handle the DiscoDuro "updated" event.
     */
public function updated($disco): void
    {
        if ($disco->isDirty()) {
            $cambios = [];

            foreach ($disco->getDirty() as $atributo => $nuevoValor) {
                // Ignorar campos de control
                if (in_array($atributo, ['updated_at', 'equipo_id', 'created_at'])) continue;

                $campoLegible = "Almacenamiento -> " . Str::headline($atributo);

                $cambios[$campoLegible] = [
                    'antes'   => $disco->getOriginal($atributo) ?: 'N/A',
                    'despues' => $nuevoValor
                ];
            }

            if (!empty($cambios)) {
                Historial_log::create([
                    'activo_id'         => $disco->equipo_id,
                    'usuario_accion_id' => Auth::id() ?? 1,
                    'tipo_registro'     => 'UPDATE',
                    'detalles_json'     => [
                        'mensaje'          => 'Se actualizó información técnica del disco',
                        'usuario_asignado' => $disco->equipo->usuario->name ?? 'N/A',
                        'rol'              => $disco->equipo->usuario->rol ?? 'N/A',
                        'cambios'          => $cambios
                    ]
                ]);
            }
        }
    }

    /**
     * Handle the DiscoDuro "deleted" event.
     */
    public function deleted(DiscoDuro $discoDuro): void
    {
        //
    }

    /**
     * Handle the DiscoDuro "restored" event.
     */
    public function restored(DiscoDuro $discoDuro): void
    {
        //
    }

    /**
     * Handle the DiscoDuro "force deleted" event.
     */
    public function forceDeleted(DiscoDuro $discoDuro): void
    {
        //
    }
}
