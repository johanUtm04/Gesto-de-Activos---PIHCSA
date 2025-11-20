<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disco_Duro extends Model
{
    use HasFactory;
    protected $table = 'discos_duros';
    protected $guarded = ['id'];
    
    public function equipos() 
    {
        return $this->belongsTo(Equipo::class, 'equipo_id'); 
    } 
}