<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConducteursSeeder extends Seeder
{
    public function run()
    {
        DB::table('conducteurs')->insert([
            'nom' => 'Jean Dupont',
            'email' => 'jean@example.com',
            'mot_de_passe' => md5('password'),
            'telephone' => '0612345699',
            'numero_permis' => 'B12345678',
            'note_moyenne' => 4.5,
            'est_bloque' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('conducteurs')->insert([
            'nom' => 'Pierre Durand',
            'email' => 'pierre@example.com',
            'mot_de_passe' => md5('password'),
            'telephone' => '0612345700',
            'numero_permis' => 'B87654321',
            'note_moyenne' => 4.8,
            'est_bloque' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}