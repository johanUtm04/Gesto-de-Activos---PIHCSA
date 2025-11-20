<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ubicacion;
use App\Models\Equipo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // Añadir el uso de DB

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

        // 1. Crear un Usuario Administrador (para iniciar sesión)
        $admin = User::create([
            'name' => 'Ingeniero Marco', 
            'email' => 'ingeniero@gmail.com', 
            'password' => Hash::make('password'), 
            'rol' => 'ADMIN',
            'departamento' => 'SISTEMAS',
            'estatus' => 'ACTIVO',
        ]);
/* +----------------+---------------------+------+-----+----------+----------------+
| Field          | Type                | Null | Key | Default  | Extra          |
+----------------+---------------------+------+-----+----------+----------------+
| id             | bigint(20) unsigned | NO   | PRI | NULL     | auto_increment |
| name           | varchar(255)        | NO   |     | NULL     |                |
| email          | varchar(255)        | NO   | UNI | NULL     |                |
| rol            | varchar(50)         | NO   |     | SISTEMAS |                |
| departamento   | varchar(255)        | YES  |     | NULL     |                |
| password       | varchar(255)        | NO   |     | NULL     |                |
| estatus        | varchar(50)         | NO   |     | ACTIVO   |                |
| remember_token | varchar(100)        | YES  |     | NULL     |                |
| created_at     | timestamp           | YES  |     | NULL     |                |
| updated_at     | timestamp           | YES  |     | NULL     |                |
+----------------+---------------------+------+-----+----------+----------------+ */

        $ubi_soporte = Ubicacion::create([
            'nombre' => 'Oficina de Sistemas', 
            'codigo' => 'OS001'
        ]);
/* +------------+---------------------+------+-----+---------+----------------+
| Field      | Type                | Null | Key | Default | Extra          |
+------------+---------------------+------+-----+---------+----------------+
| id         | bigint(20) unsigned | NO   | PRI | NULL    | auto_increment |
| nombre     | varchar(255)        | NO   |     | NULL    |                |
| codigo     | varchar(255)        | NO   |     | NULL    |                |
| created_at | timestamp           | YES  |     | NULL    |                |
| updated_at | timestamp           | YES  |     | NULL    |                |
+------------+---------------------+------+-----+---------+----------------+ */


        Equipo::create([
            'upc_code' => 'PC-LAP-1001',
            'serial_number' => 'SN-XYZ-789',
            'tipo_equipo' => 'Laptop',
            'estado' => 'ACTIVO',
            
            // Asignaciones (Claves Foráneas)
            'usuario_id' => $admin->id, // Asignado al Admin Global
            'ubicacion_id' => $ubi_soporte->id, // Asignado a la Oficina de Soporte
            
            // Datos M-4 (Financieros)
            'valor_inicial' => 1250.50,
            'fecha_adquisicion' => now()->subMonths(6),
            'vida_util_estimada' => 48,
        ]);

        
        User::factory(10)->create();
    }
}