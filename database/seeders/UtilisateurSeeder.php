<?php

namespace Database\Seeders;

use App\Models\Utilisateur;
use App\Models\Passager;
use App\Models\Conducteur;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UtilisateurSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = Utilisateur::create([
            'nom' => 'Admin System',
            'email' => 'admin@cotransport.com',
            'mot_de_passe' => Hash::make('password'),
            'telephone' => '0612345678',
            'type' => 'admin',
            'statut_compte' => 'actif'
        ]);
        Admin::create(['utilisateur_id' => $admin->id, 'niveau_acces' => 'super_admin']);

        // Conducteur 1
        $cond1 = Utilisateur::create([
            'nom' => 'Mohamed Alami',
            'email' => 'mohamed@example.com',
            'mot_de_passe' => Hash::make('password'),
            'telephone' => '0612345679',
            'type' => 'conducteur',
            'statut_compte' => 'actif'
        ]);
        Conducteur::create([
            'utilisateur_id' => $cond1->id,
            'numero_permis' => 'P123456789',
            'verification' => true,
            'note_moyenne' => 4.5
        ]);

        // Conducteur 2
        $cond2 = Utilisateur::create([
            'nom' => 'Fatima Benali',
            'email' => 'fatima@example.com',
            'mot_de_passe' => Hash::make('password'),
            'telephone' => '0612345680',
            'type' => 'conducteur',
            'statut_compte' => 'actif'
        ]);
        Conducteur::create([
            'utilisateur_id' => $cond2->id,
            'numero_permis' => 'P987654321',
            'verification' => true,
            'note_moyenne' => 4.8
        ]);

        // Passager 1
        $pass1 = Utilisateur::create([
            'nom' => 'Karim Idrissi',
            'email' => 'karim@example.com',
            'mot_de_passe' => Hash::make('password'),
            'telephone' => '0612345681',
            'type' => 'passager',
            'statut_compte' => 'actif'
        ]);
        Passager::create([
            'utilisateur_id' => $pass1->id,
            'points_fidelite' => 100,
            'note_moyenne' => 4.2
        ]);

        // Passager 2
        $pass2 = Utilisateur::create([
            'nom' => 'Sara Tazi',
            'email' => 'sara@example.com',
            'mot_de_passe' => Hash::make('password'),
            'telephone' => '0612345682',
            'type' => 'passager',
            'statut_compte' => 'actif'
        ]);
        Passager::create([
            'utilisateur_id' => $pass2->id,
            'points_fidelite' => 50
        ]);
    }
}