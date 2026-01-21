<?php

namespace App\Observers;

use App\Models\Procesador;
use App\Models\Historial_log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
public function deleting(Procesador $procesador): void
{
    // 1.- Obtenemos el ID directamente de la columna, no de la relación es decir, $168 por ejemplo
    $equipoId = $procesador->equipo_id; 

    // 2. Buscamos el equipo de forma manual para asegurar que exista
    //es decir buscamos ese registro en la tabla
    $equipoPadre = \App\Models\Equipo::find($equipoId);

    //3.- Si la Tomamos de Buena Manera crearemos un registro en Historial_Log
    if ($equipoPadre) {
        Historial_log::create([
            'activo_id'         => $equipoPadre->id, // Vinculamos al ID del equipo
            'usuario_accion_id' => \Illuminate\Support\Facades\Auth::id() ?? 1,
            'tipo_registro'     => 'DELETE',
            'detalles_json'     => [
                'mensaje'          => "COMPONENTE ELIMINADO: Se retiró un procesador del equipo",
                'usuario_asignado' => $equipoPadre->usuario->name ?? 'N/A',
                'rol'              => $equipoPadre->usuario->rol ?? 'N/A',
                'cambios'          => [
                    'Procesador Retirado' => [
                        'antes'   => "Marca: {$procesador->marca} | Desc: {$procesador->descripcion_tipo}",
                        'despues' => 'ELIMINADO'
                    ]
                ],
                'respaldo' => $procesador->toArray() 
            ]
        ]);
    } else {    //4.-En caso de Error
        Log::warning("No se pudo crear log de eliminación: El procesador {$procesador->id} no tiene un equipo asociado.");
    }
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
