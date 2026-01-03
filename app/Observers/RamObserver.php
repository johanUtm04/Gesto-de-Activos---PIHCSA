<?php

namespace App\Observers;

use App\Models\Ram;
use App\Models\Historial_log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class RamObserver
{
    /**
     * Handle the Ram "created" event.
     */
public function created(Ram $ram): void
    {
        // Obtenemos el equipo al que se le sumó a la ram
        $equipo = $ram->equipos; 

        if ($equipo) {
            Historial_log::create([
                'activo_id'         => $equipo->id,
                'usuario_accion_id' => Auth::id() ?? 1,
                'tipo_registro'     => 'CREATE', 
                'detalles_json'     => [
                    'mensaje'          => 'NUEVO COMPONENTE: Se sumó una Ram',
                    'usuario_asignado' => $equipo->usuario->name ?? 'N/A',
                    'rol'              => $equipo->usuario->rol ?? 'N/A',
                    // Forzamos la estructura de cambios para que el Blade la pinte bonito
                    'cambios'          => [
                        'Ram Adicional' => [
                            'antes'   => 'Inexistente',
                            'despues' => "<ul class='list-unstyled mb-0'>" .
                            "<li><b>Capacidad en GB:</b> {$ram->capacidad_gb}</li>" .
                            "<li><b>Clock Mhz:</b> {$ram->clock_mhz}</li>" .
                            "<li><b>Tipo CHZ:</b> {$ram->tipo_chz}\"</li>" .
                            "</ul>"                    
                            ]
                    ]   
                ]
            ]);
        }
    }

    /**
     * Handle the Ram "updated" event.
     */
public function updated(Ram $ram): void
    {
        // 1. Verificamos si hubo cambios reales ignorando la fecha de actualización
        if ($ram->isDirty()) {
            $cambios = [];

            foreach ($ram->getDirty() as $atributo => $nuevoValor) {
                    if ($atributo === 'updated_at' || $atributo === 'equipo_id') continue;

                    // 2. Creamos una etiqueta clara para el historial
                    $campoLegible = "Ram -> " . Str::headline($atributo);

                    $cambios[$campoLegible] = [
                        'antes'   => $ram->getOriginal($atributo),
                        'despues' => $nuevoValor
                    ];
                }

                // 3. Solo creamos el log si el array de cambios no quedó vacío
                if (!empty($cambios)) {
                    Historial_log::create([
                        'activo_id'         => $ram->equipo_id, // Vinculamos al equipo padre
                        'usuario_accion_id' => Auth::id() ?? 1,
                        'tipo_registro'     => 'UPDATE',
                        'detalles_json'     => [
                            'mensaje'          => 'Se actualizó información del ram',
                            'usuario_asignado' => $ram->equipos->usuario->name ?? 'N/A',
                            'rol'              => $ram->equipos->usuario->rol ?? 'N/A',
                            'cambios'          => $cambios
                        ]
                    ]);
                }}
        }

    /**
     * Handle the Ram "deleted" event.
     */
    public function deleted(Ram $ram): void
    {
        //
    }

    /**
     * Handle the Ram "restored" event.
     */
    public function restored(Ram $ram): void
    {
        //
    }

    /**
     * Handle the Ram "force deleted" event.
     */
    public function forceDeleted(Ram $ram): void
    {
        //
    }
}
