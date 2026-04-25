<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            VillesSeeder::class,
            UtilisateursSeeder::class,  
            VehiculesSeeder::class,
            TrajetsSeeder::class,
            ReservationsSeeder::class,
            PaiementsSeeder::class,
            AvisSeeder::class,
        ]);
    }
}