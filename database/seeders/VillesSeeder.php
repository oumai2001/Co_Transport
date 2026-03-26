<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VillesSeeder extends Seeder
{
    public function run()
    {
        $villes = [
            ['nom' => 'Casablanca', 'code_postal' => '20000', 'pays' => 'Maroc', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Rabat', 'code_postal' => '10000', 'pays' => 'Maroc', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Marrakech', 'code_postal' => '40000', 'pays' => 'Maroc', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Fès', 'code_postal' => '30000', 'pays' => 'Maroc', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Tanger', 'code_postal' => '90000', 'pays' => 'Maroc', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Agadir', 'code_postal' => '80000', 'pays' => 'Maroc', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Meknès', 'code_postal' => '50000', 'pays' => 'Maroc', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Oujda', 'code_postal' => '60000', 'pays' => 'Maroc', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Tétouan', 'code_postal' => '93000', 'pays' => 'Maroc', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'El Jadida', 'code_postal' => '24000', 'pays' => 'Maroc', 'created_at' => now(), 'updated_at' => now()],
        ];
        
        DB::table('villes')->insert($villes);
    }
}