<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationsSeeder extends Seeder
{
    public function run()
    {
        $reservations = [
            [
                'passager_id' => 1, // Ahmed Rida
                'trajet_id' => 1,
                'nombre_places' => 1,
                'prix_total' => 60,
                'statut' => 'confirmee',
                'date_reservation' => now()->subDays(3),
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3)
            ],
            [
                'passager_id' => 2, // Khadija
                'trajet_id' => 2,
                'nombre_places' => 2,
                'prix_total' => 200,
                'statut' => 'confirmee',
                'date_reservation' => now()->subDays(2),
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2)
            ],
            [
                'passager_id' => 3, // Fatima Zahra
                'trajet_id' => 3,
                'nombre_places' => 1,
                'prix_total' => 80,
                'statut' => 'confirmee',
                'date_reservation' => now()->subDays(4),
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(4)
            ],
            [
                'passager_id' => 4, // Youssef
                'trajet_id' => 4,
                'nombre_places' => 1,
                'prix_total' => 150,
                'statut' => 'confirmee',
                'date_reservation' => now()->subDays(1),
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1)
            ],
            [
                'passager_id' => 5, // Sofia
                'trajet_id' => 5,
                'nombre_places' => 1,
                'prix_total' => 90,
                'statut' => 'confirmee',
                'date_reservation' => now()->subDays(5),
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5)
            ],
            [
                'passager_id' => 6, // Omar
                'trajet_id' => 6,
                'nombre_places' => 2,
                'prix_total' => 200,
                'statut' => 'en_attente',
                'date_reservation' => now()->subDays(1),
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1)
            ],
            [
                'passager_id' => 7, // Nadia
                'trajet_id' => 7, // Trajet terminé
                'nombre_places' => 1,
                'prix_total' => 60,
                'statut' => 'confirmee',
                'date_reservation' => now()->subDays(15),
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(15)
            ],
        ];
        
        DB::table('reservations')->insert($reservations);
    }
}