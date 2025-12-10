<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ubicacion;
use App\Models\Equipo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; 

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call([
            UbicacionSeeder::class,
            UserSeeder::class,
            // OtrosSeeders::class,
        ]);
    }
}