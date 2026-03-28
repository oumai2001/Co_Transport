<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaiementsSeeder extends Seeder
{
    public function run()
    {
        $paiements = [
            [
                'reservation_id' => 1,
                'montant' => 60,
                'date_paiement' => now()->subDays(3),
                'mode_paiement' => 'carte',
                'statut' => 'paye',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3)
            ],
            [
                'reservation_id' => 2,
                'montant' => 200,
                'date_paiement' => now()->subDays(2),
                'mode_paiement' => 'carte',
                'statut' => 'paye',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2)
            ],
            [
                'reservation_id' => 3,
                'montant' => 80,
                'date_paiement' => now()->subDays(4),
                'mode_paiement' => 'especes',
                'statut' => 'paye',
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(4)
            ],
            [
                'reservation_id' => 4,
                'montant' => 150,
                'date_paiement' => now()->subDays(1),
                'mode_paiement' => 'carte',
                'statut' => 'paye',
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1)
            ],
            [
                'reservation_id' => 5,
                'montant' => 90,
                'date_paiement' => now()->subDays(5),
                'mode_paiement' => 'carte',
                'statut' => 'paye',
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5)
            ],
            [
                'reservation_id' => 7,
                'montant' => 60,
                'date_paiement' => now()->subDays(15),
                'mode_paiement' => 'carte',
                'statut' => 'paye',
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(15)
            ],
        ];
        
        DB::table('paiements')->insert($paiements);
    }
}