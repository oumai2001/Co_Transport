<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsSeeder extends Seeder
{
    public function run()
    {
        DB::table('admins')->insert([
            'nom' => 'Administrateur',
            'email' => 'admin@cotransport.com',
            'mot_de_passe' => md5('admin123'),
            'telephone' => '0123456789',
            'niveau_acces' => 'full',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}