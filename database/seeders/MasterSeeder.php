<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Equipo;
use App\Models\User;
use App\Models\Ubicacion;
use App\Models\Monitor;
use App\Models\DiscoDuro;
use App\Models\Ram;
use App\Models\Periferico;
use App\Models\Procesador;


class MasterSeeder extends Seeder
{
public function run(): void
    {
        // 1. Asegurar la existencia de datos PADRE (belongsTo)
        // Creamos 5 usuarios y 3 ubicaciones. Esto nos da IDs fijos para asignar.
        $usuarios = User::factory()->count(5)->create();
        $ubicaciones = Ubicacion::factory()->count(3)->create();

        // 2. CREACIÓN DE 10 EQUIPOS COMPLETOS Y ASOCIACIÓN DE COMPONENTES (hasMany)
        
        Equipo::factory()
            ->count(10) // Queremos 10 equipos
            
            // --- RELACIONES HAS MANY (Componentes del Equipo) ---
            // 'monitores' es el nombre del método de relación en el modelo Equipo.
            ->has(Monitor::factory()->count(rand(1, 2)), 'monitores') 
            ->has(DiscoDuro::factory()->count(2), 'discosDuros')
            ->has(Ram::factory()->count(4), 'rams') 
            ->has(Periferico::factory()->count(1), 'perifericos') 
            ->has(Procesador::factory()->count(1), 'procesadores') 
            
            // --- Sobrescribir las asignaciones (belongsTo) ---
            ->create([
                // Asignamos el usuario_id y ubicacion_id 
                // con un ID aleatorio de las colecciones que creamos al inicio (Paso 1).
                'usuario_id' => $usuarios->random()->id,
                'ubicacion_id' => $ubicaciones->random()->id,
            ]);

        // Al finalizar este código, habrás creado 10 Equipos y
        // aproximadamente 10-20 Monitores, 20 Discos, 40 RAMs, etc., todos correctamente enlazados.
    }
}
