<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PassagersSeeder extends Seeder
{
    public function run()
    {
        DB::table('passagers')->insert([
            'nom' => 'Marie Martin',
            'email' => 'marie@example.com',
            'mot_de_passe' => md5('password'),
            'telephone' => '0612345678',
            'points_fidelite' => 100,
            'est_bloque' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('passagers')->insert([
            'nom' => 'Sophie Bernard',
            'email' => 'sophie@example.com',
            'mot_de_passe' => md5('password'),
            'telephone' => '0687654321',
            'points_fidelite' => 50,
            'est_bloque' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}