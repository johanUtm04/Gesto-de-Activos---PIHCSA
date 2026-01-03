<?php

namespace App\Observers;

use App\Models\Periferico;
use App\Models\Historial_log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class PerifericoObserver
{
    /**
     * Handle the Periferico "created" event.
     */
    public function created(Periferico $periferico): void
    {
        // Obtenemos el equipo al que se le sumó el monitor
        $equipo = $periferico->equipos; 

        if ($equipo) {
            Historial_log::create([
                'activo_id'         => $equipo->id,
                'usuario_accion_id' => Auth::id() ?? 1,
                'tipo_registro'     => 'CREATE', 
                'detalles_json'     => [
                    'mensaje'          => 'NUEVO COMPONENTE: Se sumó un Periferico',
                    'usuario_asignado' => $equipo->usuario->name ?? 'N/A',
                    'rol'              => $equipo->usuario->rol ?? 'N/A',
                    // Forzamos la estructura de cambios para que el Blade la pinte bonito
                    'cambios'          => [
                        'Periferico Adicional' => [
                            'antes'   => 'Inexistente',
                            'despues' => "<ul class='list-unstyled mb-0'>" .
                            "<li><b>Marca:</b> {$periferico->tipo}</li>" .
                            "<li><b>S/N:</b> {$periferico->marca}</li>" .
                            "<li><b>Escala:</b> {$periferico->serial}\"</li>" .
                            "<li><b>Interface:</b> {$periferico->interface}</li>" .
                            "</ul>"                    
                            ]
                    ]   
                ]
            ]);
        }
    }

    /**
     * Handle the Periferico "updated" event.
     */
    public function updated(Periferico $periferico): void
    {
        //
        if ($periferico->isDirty()) {
            # code...
            $cambios = [];
            
            foreach($periferico->getDirty() as $atributo => $nuevovalor){
                if ($atributo === 'updated_at' || $atributo === 'equipo_id') continue; 

                $campoLegible = "Periferico -> " . Str::headline($atributo);

                $cambios[$campoLegible] = [
                    'antes' => $periferico->getOriginal($atributo),
                    'despues' => $nuevovalor
                ];
            }

            // 3. Solo creamos el log si el array de cambios no quedó vacío
            if (!empty($cambios)) {
                Historial_log::create([
                    'activo_id'         => $periferico->equipo_id, // Vinculamos al equipo padre
                    'usuario_accion_id' => Auth::id() ?? 1,
                    'tipo_registro'     => 'UPDATE',
                    'detalles_json'     => [
                        'mensaje'          => 'Se actualizó información del periiferico',
                        'usuario_asignado' => $periferico->equipos->usuario->name ?? 'N/A',
                        'rol'              => $periferico->equipos->usuario->rol ?? 'N/A',
                        'cambios'          => $cambios
                    ]
                ]);
            }

        }
    }

    /**
     * Handle the Periferico "deleted" event.
     */
    public function deleted(Periferico $periferico): void
    {
        //
    }

    /**
     * Handle the Periferico "restored" event.
     */
    public function restored(Periferico $periferico): void
    {
        //
    }

    /**
     * Handle the Periferico "force deleted" event.
     */
    public function forceDeleted(Periferico $periferico): void
    {
        //
    }
}
