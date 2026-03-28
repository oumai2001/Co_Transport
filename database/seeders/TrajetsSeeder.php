<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrajetsSeeder extends Seeder
{
    public function run()
    {
        $trajets = [
            [
                'conducteur_id' => 1,
                'vehicule_id' => 1,
                'ville_depart_id' => 1, // Casablanca
                'ville_arrivee_id' => 2, // Rabat
                'date_depart' => now()->addDays(2)->setTime(8, 0, 0),
                'date_arrivee' => now()->addDays(2)->setTime(9, 30, 0),
                'prix' => 60,
                'places_disponibles' => 3,
                'statut' => 'programme',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'conducteur_id' => 2,
                'vehicule_id' => 3,
                'ville_depart_id' => 1, // Casablanca
                'ville_arrivee_id' => 3, // Marrakech
                'date_depart' => now()->addDays(3)->setTime(7, 0, 0),
                'date_arrivee' => now()->addDays(3)->setTime(10, 0, 0),
                'prix' => 100,
                'places_disponibles' => 4,
                'statut' => 'programme',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'conducteur_id' => 3,
                'vehicule_id' => 4,
                'ville_depart_id' => 2, // Rabat
                'ville_arrivee_id' => 4, // Fès
                'date_depart' => now()->addDays(1)->setTime(14, 0, 0),
                'date_arrivee' => now()->addDays(1)->setTime(16, 30, 0),
                'prix' => 80,
                'places_disponibles' => 4,
                'statut' => 'programme',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'conducteur_id' => 4,
                'vehicule_id' => 5,
                'ville_depart_id' => 5, // Tanger
                'ville_arrivee_id' => 1, // Casablanca
                'date_depart' => now()->addDays(4)->setTime(6, 0, 0),
                'date_arrivee' => now()->addDays(4)->setTime(11, 0, 0),
                'prix' => 150,
                'places_disponibles' => 4,
                'statut' => 'programme',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'conducteur_id' => 5,
                'vehicule_id' => 6,
                'ville_depart_id' => 3, // Marrakech
                'ville_arrivee_id' => 6, // Agadir
                'date_depart' => now()->addDays(5)->setTime(9, 0, 0),
                'date_arrivee' => now()->addDays(5)->setTime(12, 0, 0),
                'prix' => 90,
                'places_disponibles' => 3,
                'statut' => 'programme',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'conducteur_id' => 6,
                'vehicule_id' => 7,
                'ville_depart_id' => 4, // Fès
                'ville_arrivee_id' => 1, // Casablanca
                'date_depart' => now()->addDays(2)->setTime(16, 0, 0),
                'date_arrivee' => now()->addDays(2)->setTime(19, 0, 0),
                'prix' => 100,
                'places_disponibles' => 4,
                'statut' => 'programme',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Trajet déjà passé (terminé)
            [
                'conducteur_id' => 1,
                'vehicule_id' => 2,
                'ville_depart_id' => 1, // Casablanca
                'ville_arrivee_id' => 2, // Rabat
                'date_depart' => now()->subDays(5)->setTime(8, 0, 0),
                'date_arrivee' => now()->subDays(5)->setTime(9, 30, 0),
                'prix' => 60,
                'places_disponibles' => 0,
                'statut' => 'termine',
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(5)
            ],
        ];
        
        DB::table('trajets')->insert($trajets);
    }
}