<?php

namespace App\Observers;

use App\Models\Equipo;
use App\Services\AuditService;
use Illuminate\Support\Facades\Auth;


//1.-Importamos el modelo de la tabla de historiales
use App\Models\Historial_log;

class EquipoObserver
{
    /**
     * Handle the Equipo "created" event.
     */
    public function created(Equipo $equipo): void
    {
        //2.se dispara luego de crear un equipo
        Historial_log::create([
            'activo_id'         => $equipo->id,
            'usuario_accion_id' => Auth::id() ?? 1, // ID del usuario o sistema
            'tipo_registro'     => 'CREATE',
            'detalles_json'     => [
                'mensaje' => 'Creacion de Equipo',
                'usuario_asignado' => $equipo->usuario->name ?? 'N/A',
                'rol' => $equipo->usuario->rol ?? 'N/A',
                'datos'   => $equipo->toArray()
            ]
        ]);
    }

    public function updated(Equipo $equipo)
        {
            //1.-Solo registramos si hubo cambios reales (isDirty)
            if ($equipo->isDirty()) {
                $cambios = [];
                //Devolvemos Unicamente la columnas que fueron Modificadas
                foreach ($equipo->getDirty() as $atributo => $nuevoValor) {
                    $cambios[$atributo] = [
                        'antes'  => $equipo->getOriginal($atributo),
                        'despues' => $nuevoValor
                    ];
                }

                Historial_log::create([
                    'activo_id'         => $equipo->id,
                    'usuario_accion_id' => Auth::id() ?? 1,
                    'tipo_registro'     => 'UPDATE',
                    'detalles_json'     => [
                        'mensaje' => 'Se modificaron campos del equipo',
                        'usuario_asignado' => $equipo->usuario->name ?? 'N/A',
                        'rol' => $equipo->usuario->rol ?? 'N/A',
                        'cambios' => $cambios
                        
                    ]
                ]);
            }
        }


    public function deleting(Equipo $equipo)
    {
        Historial_log::delete([
            'activo_id'         => $equipo->id,
            'usuario_accion_id' => Auth::id() ?? 1,
            'tipo_registro'     => 'DELETE',
            'detalles_json'     => [
                'mensaje' => 'Equipo eliminado del sistema',
                'ultimo_estado' => $equipo->toArray()
            ]
        ]);
    }
}
