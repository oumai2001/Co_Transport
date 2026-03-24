<?php

namespace Database\Seeders;

use App\Models\Trajet;
use App\Models\Vehicule;
use App\Models\Conducteur;
use Illuminate\Database\Seeder;

class TrajetSeeder extends Seeder
{
    public function run(): void
    {
        $conducteur1 = Conducteur::first();
        $conducteur2 = Conducteur::skip(1)->first();

        // Créer des véhicules
        $vehicule1 = $conducteur1->vehicules()->create([
            'immatriculation' => 'AB-123-CD',
            'marque' => 'Renault',
            'modele' => 'Clio',
            'capacite' => 4,
            'statut' => 'disponible'
        ]);

        $vehicule2 = $conducteur2->vehicules()->create([
            'immatriculation' => 'EF-456-GH',
            'marque' => 'Peugeot',
            'modele' => '208',
            'capacite' => 5,
            'statut' => 'disponible'
        ]);

        // Trajet 1
        Trajet::create([
            'ville_depart_id' => 1, // Casablanca
            'ville_arrivee_id' => 2, // Rabat
            'date_depart' => now()->addDays(1)->setTime(8, 0),
            'prix' => 50,
            'places_totales' => 4,
            'places_disponibles' => 3,
            'statut' => 'programmé',
            'conducteur_id' => $conducteur1->id,
            'vehicule_id' => $vehicule1->id
        ]);

        // Trajet 2
        Trajet::create([
            'ville_depart_id' => 2, // Rabat
            'ville_arrivee_id' => 1, // Casablanca
            'date_depart' => now()->addDays(1)->setTime(17, 0),
            'prix' => 50,
            'places_totales' => 4,
            'places_disponibles' => 4,
            'statut' => 'programmé',
            'conducteur_id' => $conducteur1->id,
            'vehicule_id' => $vehicule1->id
        ]);

        // Trajet 3
        Trajet::create([
            'ville_depart_id' => 1, // Casablanca
            'ville_arrivee_id' => 3, // Tanger
            'date_depart' => now()->addDays(2)->setTime(7, 0),
            'prix' => 120,
            'places_totales' => 5,
            'places_disponibles' => 3,
            'statut' => 'programmé',
            'conducteur_id' => $conducteur2->id,
            'vehicule_id' => $vehicule2->id
        ]);

        // Trajet 4
        Trajet::create([
            'ville_depart_id' => 3, // Tanger
            'ville_arrivee_id' => 1, // Casablanca
            'date_depart' => now()->addDays(3)->setTime(15, 0),
            'prix' => 120,
            'places_totales' => 5,
            'places_disponibles' => 5,
            'statut' => 'programmé',
            'conducteur_id' => $conducteur2->id,
            'vehicule_id' => $vehicule2->id
        ]);
    }
}