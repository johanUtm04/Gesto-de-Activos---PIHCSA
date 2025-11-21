<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{

    protected $fillable = [
    'marca_equipo',
    'tipo_equipo',
    'serial',
    'sistema_operativo',
    'usuario_id',
    'ubicacion_id',
    'valor_inicial',
    'fecha_adquisicion',
    'vida_util_estimada',
    ];

    // Relación con usuario
    public function usuario() { return $this->belongsTo(User::class); }

    // Relación con ubicación
    public function ubicacion() { return $this->belongsTo(Ubicacion::class); }

    // Relación 1 a 1
    public function ram() { return $this->belongsTo(Ram::class); }
    public function discoDuro() { return $this->belongsTo(Disco_Duro::class); }
    public function monitor() { return $this->belongsTo(Monitor::class); }

    // Relación 1 a muchos
    public function perifericos()
    {
        return $this->belongsToMany(Periferico::class, 'equipo_periferico');
    }
    public function procesadores()
    {
    return $this->belongsToMany(Procesador::class, 'equipo_procesador');
    }

}
