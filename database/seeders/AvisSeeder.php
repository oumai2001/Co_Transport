<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AvisSeeder extends Seeder
{
    public function run()
    {
        $avis = [
            [
                'reservation_id' => 7,
                'passager_id' => 7,
                'conducteur_id' => 1,
                'note' => 5,
                'commentaire' => 'Très bon conducteur, ponctuel et sympathique !',
                'created_at' => now()->subDays(10)
            ],
            [
                'reservation_id' => 1,
                'passager_id' => 1,
                'conducteur_id' => 1,
                'note' => 4,
                'commentaire' => 'Bon trajet, conducteur agréable.',
                'created_at' => now()->subDays(2)
            ],
            [
                'reservation_id' => 2,
                'passager_id' => 2,
                'conducteur_id' => 2,
                'note' => 5,
                'commentaire' => 'Excellent ! Voiture propre et conduite sécurisée.',
                'created_at' => now()->subDays(1)
            ],
            [
                'reservation_id' => 3,
                'passager_id' => 3,
                'conducteur_id' => 3,
                'note' => 4,
                'commentaire' => 'Bon voyage, un peu de retard mais compréhensible.',
                'created_at' => now()->subDays(3)
            ],
            [
                'reservation_id' => 4,
                'passager_id' => 4,
                'conducteur_id' => 4,
                'note' => 5,
                'commentaire' => 'Super conducteur, très professionnel !',
                'created_at' => now()->subDays(4)
            ],
        ];
        
        DB::table('avis')->insert($avis);
    }
}