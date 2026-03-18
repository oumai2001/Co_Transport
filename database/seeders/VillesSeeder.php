<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VillesSeeder extends Seeder
{
    public function run()
    {
        $villes = [
            ['nom' => 'Paris', 'code_postal' => '75001', 'pays' => 'France', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Lyon', 'code_postal' => '69001', 'pays' => 'France', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Marseille', 'code_postal' => '13001', 'pays' => 'France', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Toulouse', 'code_postal' => '31000', 'pays' => 'France', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Bordeaux', 'code_postal' => '33000', 'pays' => 'France', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Lille', 'code_postal' => '59000', 'pays' => 'France', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Nice', 'code_postal' => '06000', 'pays' => 'France', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Nantes', 'code_postal' => '44000', 'pays' => 'France', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Strasbourg', 'code_postal' => '67000', 'pays' => 'France', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Montpellier', 'code_postal' => '34000', 'pays' => 'France', 'created_at' => now(), 'updated_at' => now()],
        ];
        
        DB::table('villes')->insert($villes);
    }
}