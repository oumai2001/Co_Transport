<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UtilisateursSeeder extends Seeder
{
    public function run()
    {
        // PASSAGERS (avec utilisateur)
        $passagers = [
            ['nom' => 'Ahmed Rida', 'email' => 'ahmed.rida@gmail.com', 'telephone' => '0612345601', 'est_bloque' => false],
            ['nom' => 'Khadija Benjelloun', 'email' => 'khadija.benjelloun@gmail.com', 'telephone' => '0612345602', 'est_bloque' => false],
            ['nom' => 'Fatima Zahra', 'email' => 'fatima.zahra@gmail.com', 'telephone' => '0612345603', 'est_bloque' => false],
            ['nom' => 'Youssef Amrani', 'email' => 'youssef.amrani@gmail.com', 'telephone' => '0612345604', 'est_bloque' => false],
            ['nom' => 'Sofia El Mansouri', 'email' => 'sofia.elmansouri@gmail.com', 'telephone' => '0612345605', 'est_bloque' => false],
            ['nom' => 'Omar Tazi', 'email' => 'omar.tazi@gmail.com', 'telephone' => '0612345606', 'est_bloque' => false],
            ['nom' => 'Nadia Fassi', 'email' => 'nadia.fassi@gmail.com', 'telephone' => '0612345607', 'est_bloque' => false],
        ];

        // CONDUCTEURS (avec utilisateur)
        $conducteurs = [
            ['nom' => 'Mohammed Berrada', 'email' => 'mohammed.berrada@gmail.com', 'telephone' => '0612345701', 'numero_permis' => 'B123456789', 'note_moyenne' => 4.8, 'est_bloque' => false],
            ['nom' => 'Rachid El Fassi', 'email' => 'rachid.elfassi@gmail.com', 'telephone' => '0612345702', 'numero_permis' => 'B234567890', 'note_moyenne' => 4.5, 'est_bloque' => false],
            ['nom' => 'Hassan Chraibi', 'email' => 'hassan.chraibi@gmail.com', 'telephone' => '0612345703', 'numero_permis' => 'B345678901', 'note_moyenne' => 4.2, 'est_bloque' => false],
            ['nom' => 'Karim Benjelloun', 'email' => 'karim.benjelloun@gmail.com', 'telephone' => '0612345704', 'numero_permis' => 'B456789012', 'note_moyenne' => 4.9, 'est_bloque' => false],
            ['nom' => 'Said El Ouafi', 'email' => 'said.elouafi@gmail.com', 'telephone' => '0612345705', 'numero_permis' => 'B567890123', 'note_moyenne' => 3.8, 'est_bloque' => false],
            ['nom' => 'Younes Bennani', 'email' => 'younes.bennani@gmail.com', 'telephone' => '0612345706', 'numero_permis' => 'B678901234', 'note_moyenne' => 4.7, 'est_bloque' => false],
        ];

        // ADMIN
        $admin = ['nom' => 'Administrateur', 'email' => 'admin@gmail.com', 'telephone' => '0123456789'];

        $password = Hash::make('123456');

        // Insérer les passagers
        foreach ($passagers as $p) {
            $utilisateurId = DB::table('utilisateurs')->insertGetId([
                'nom' => $p['nom'],
                'email' => $p['email'],
                'password' => $password,
                'telephone' => $p['telephone'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('passagers')->insert([
                'utilisateur_id' => $utilisateurId,
                'est_bloque' => $p['est_bloque'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Insérer les conducteurs
        foreach ($conducteurs as $c) {
            $utilisateurId = DB::table('utilisateurs')->insertGetId([
                'nom' => $c['nom'],
                'email' => $c['email'],
                'password' => $password,
                'telephone' => $c['telephone'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('conducteurs')->insert([
                'utilisateur_id' => $utilisateurId,
                'numero_permis' => $c['numero_permis'],
                'note_moyenne' => $c['note_moyenne'],
                'est_bloque' => $c['est_bloque'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Insérer l'admin
        $utilisateurId = DB::table('utilisateurs')->insertGetId([
            'nom' => $admin['nom'],
            'email' => $admin['email'],
            'password' => $password,
            'telephone' => $admin['telephone'],
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('admins')->insert([
            'utilisateur_id' => $utilisateurId,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}