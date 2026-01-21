<?php

namespace App\Observers;

use App\Models\Equipo;
use App\Services\AuditService;
use Illuminate\Support\Facades\Auth;


//1.-Importamos el modelo de la tabla de historiales
use App\Models\Historial_log;

class EquipoObserver
{
    // Esta variable vive solo durante la ejecución de la página actual
    protected static $registrado = false;
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
            // Si ya se registró un log en esta carga, ignora el resto
            if (self::$registrado) return;
            //1.-Solo registramos si hubo cambios reales (isDirty)
            if ($equipo->isDirty()) {
                $cambios = [];
                //Devolvemos Unicamente la columnas que fueron Modificadas
                foreach ($equipo->getDirty() as $atributo => $nuevoValor) {
                if ($atributo === 'updated_at') continue; //Opcional: saltarse feche de Actualizacion 
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

                // Marcamos que ya cumplimos la misión
                self::$registrado = true;
            }
        }

public function deleting(Equipo $equipo)
    {
        Historial_log::create([
            'activo_id'         => $equipo->id, // El ID se queda grabado como número
            'usuario_accion_id' => Auth::id() ?? 1,
            'tipo_registro'     => 'DELETE',
            'detalles_json'     => [
                'mensaje' => 'ELIMINACIÓN DEFINITIVA: El activo ha sido removido.',
                'usuario_asignado' => $equipo->usuario->name ?? 'N/A',
                'rol' => $equipo->usuario->rol ?? 'N/A',
                'cambios' => [
                    'Registro Eliminado' => [
                        'antes' => "Equipo: {$equipo->nombre_equipo} | S/N: {$equipo->serial}",
                        'despues' => 'BORRADO POR USUARIO'
                    ]
                ],
                // GUARDAMOS TODO EL EQUIPO AQUÍ ADENTRO POR SEGURIDAD
                'respaldo_total' => $equipo->toArray() 
            ]
        ]);
    }
}
