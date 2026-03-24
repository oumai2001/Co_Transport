<?php

namespace Database\Seeders;

use App\Models\Ville;
use Illuminate\Database\Seeder;

class VilleSeeder extends Seeder
{
    public function run(): void
    {
        $villes = [
            ['nom' => 'Casablanca', 'code_postal' => '20000', 'pays' => 'Maroc'],
            ['nom' => 'Rabat', 'code_postal' => '10000', 'pays' => 'Maroc'],
            ['nom' => 'Tanger', 'code_postal' => '90000', 'pays' => 'Maroc'],
            ['nom' => 'Fès', 'code_postal' => '30000', 'pays' => 'Maroc'],
            ['nom' => 'Marrakech', 'code_postal' => '40000', 'pays' => 'Maroc'],
            ['nom' => 'Agadir', 'code_postal' => '80000', 'pays' => 'Maroc'],
            ['nom' => 'Meknès', 'code_postal' => '50000', 'pays' => 'Maroc'],
            ['nom' => 'Oujda', 'code_postal' => '60000', 'pays' => 'Maroc'],
        ];

        foreach ($villes as $ville) {
            Ville::create($ville);
        }
    }
}