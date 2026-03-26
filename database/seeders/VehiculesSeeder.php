<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehiculesSeeder extends Seeder
{
    public function run()
    {
        $vehicules = [
            [
                'immatriculation' => 'AB 123 CD',
                'marque' => 'Dacia',
                'modele' => 'Logan',
                'capacite' => 4,
                'statut' => 'disponible',
                'conducteur_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'immatriculation' => 'CD 456 EF',
                'marque' => 'Renault',
                'modele' => 'Clio',
                'capacite' => 4,
                'statut' => 'disponible',
                'conducteur_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'immatriculation' => 'EF 789 GH',
                'marque' => 'Peugeot',
                'modele' => '208',
                'capacite' => 5,
                'statut' => 'disponible',
                'conducteur_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'immatriculation' => 'GH 012 IJ',
                'marque' => 'Volkswagen',
                'modele' => 'Golf',
                'capacite' => 5,
                'statut' => 'maintenance',
                'conducteur_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'immatriculation' => 'IJ 345 KL',
                'marque' => 'Toyota',
                'modele' => 'Corolla',
                'capacite' => 5,
                'statut' => 'disponible',
                'conducteur_id' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'immatriculation' => 'KL 678 MN',
                'marque' => 'Hyundai',
                'modele' => 'i10',
                'capacite' => 4,
                'statut' => 'disponible',
                'conducteur_id' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'immatriculation' => 'MN 901 OP',
                'marque' => 'Ford',
                'modele' => 'Focus',
                'capacite' => 5,
                'statut' => 'disponible',
                'conducteur_id' => 6,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
        
        DB::table('vehicules')->insert($vehicules);
    }
}