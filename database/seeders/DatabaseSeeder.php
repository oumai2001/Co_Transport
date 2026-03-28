<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            VillesSeeder::class,
            UtilisateursSeeder::class,  // ← NOUVEAU : crée utilisateurs + passagers/conducteurs/admins
            VehiculesSeeder::class,
            TrajetsSeeder::class,
            ReservationsSeeder::class,
            PaiementsSeeder::class,
            AvisSeeder::class,
        ]);
    }
}