<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    // CRÍTICO: Debe apuntar a la tabla correcta en la DB.
    protected $table = 'equipos'; 
    protected $guarded = ['id'];

    // === ASIGNACIÓN Y TRAZABILIDAD (belongsTo y hasMany) ===

    /**
     * Recepción N:1 (Un equipo pertenece a una Ubicación)
     */
    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'ubicacion_id'); 
    }

    /**
     * Recepción N:1 (Un equipo pertenece a un Usuario responsable)
     */
    public function responsable() // Cambiado de 'users' a 'responsable' para claridad
    {
        return $this->belongsTo(User::class, 'usuario_id'); 
    }

    /**
     * Expulsión 1:N (Un equipo tiene muchos logs)
     */
    public function historialLogs()
    {
        // Cambiado a HistorialLog::class y nombre de función en plural
        return $this->hasMany(Historial_log::class, 'activo_id'); 
    }

    // === COMPONENTES 1:1 (hasOne) ===

    public function discoDuro()
    {
        return $this->hasOne(Disco_duro::class, 'equipo_id'); 
    }

    public function monitor()
    {
        return $this->hasOne(Monitor::class, 'equipo_id'); 
    }

    // Si solo hay un slot de RAM principal (asumido para 1:1)
    public function ram() 
    {
        return $this->hasOne(Ram::class, 'equipo_id'); 
    }

    // === PROCESADOR 1:1 (Corregido a hasOne) ===
    public function procesador()
    {
        return $this->hasOne(Procesador::class, 'equipo_id'); 
    }

    // === PERIFÉRICOS 1:N (hasMany) ===
    // Asumimos que un equipo puede tener varios periféricos (teclado, ratón, cámara)
    public function perifericos()
    {
        return $this->hasMany(Periferico::class, 'equipo_id'); 
    }
}