<?php

namespace App\Observers;

use App\Models\Procesador;
use App\Models\Historial_log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
class ProcesadorObserver
{
    /**
     * Handle the Procesador "created" event.
     */
    public function created(Procesador $procesador): void
    {
        // Obtenemos el equipo al que se le sumó el procesador
        $equipo = $procesador->equipos; 

        if ($equipo) {
            Historial_log::create([
                'activo_id'         => $equipo->id,
                'usuario_accion_id' => Auth::id() ?? 1,
                'tipo_registro'     => 'CREATE', 
                'detalles_json'     => [
                    'mensaje'          => 'NUEVO COMPONENTE: Se sumó un procesador',
                    'usuario_asignado' => $equipo->usuario->name ?? 'N/A',
                    'rol'              => $equipo->usuario->rol ?? 'N/A',
                    // Forzamos la estructura de cambios para que el Blade la pinte bonito
                    'cambios'          => [
                        'Procesador Adicional' => [
                            'antes'   => 'Inexistente',
                            'despues' => "<ul class='list-unstyled mb-0'>" .
                            "<li><b>Marca:</b> {$procesador->marca}</li>" .
                            "<li><b>S/N:</b> {$procesador->descripcion_tipo}</li>" .
                            "</ul>"                    
                            ]
                    ]   
                ]
            ]);
        }
    }

    /**
     * Handle the Procesador "updated" event.
     */
    public function updated(Procesador $procesador): void
    {
        //

        // 1. Verificamos si hubo cambios reales ignorando la fecha de actualización
        if ($procesador->isDirty()) {
            $cambios = [];

            foreach ($procesador->getDirty() as $atributo => $nuevoValor) {
                    if ($atributo === 'updated_at' || $atributo === 'equipo_id') continue;

                    // 2. Creamos una etiqueta clara para el historial
                    $campoLegible = "Procesador -> " . Str::headline($atributo);

                    $cambios[$campoLegible] = [
                        'antes'   => $procesador->getOriginal($atributo),
                        'despues' => $nuevoValor
                    ];
                }

                // 3. Solo creamos el log si el array de cambios no quedó vacío
                if (!empty($cambios)) {
                    Historial_log::create([
                        'activo_id'         => $procesador->equipo_id, // Vinculamos al equipo padre
                        'usuario_accion_id' => Auth::id() ?? 1,
                        'tipo_registro'     => 'UPDATE',
                        'detalles_json'     => [
                            'mensaje'          => 'Se actualizó información del procesador',
                            'usuario_asignado' => $procesador->equipos->usuario->name ?? 'N/A',
                            'rol'              => $procesador->equipos->usuario->rol ?? 'N/A',
                            'cambios'          => $cambios
                        ]
                    ]);
                }}
        }

    /**
     * Handle the Procesador "deleted" event.
     */
    public function deleted(Procesador $procesador): void
    {
        //
    }

    /**
     * Handle the Procesador "restored" event.
     */
    public function restored(Procesador $procesador): void
    {
        //
    }

    /**
     * Handle the Procesador "force deleted" event.
     */
    public function forceDeleted(Procesador $procesador): void
    {
        //
    }
}
