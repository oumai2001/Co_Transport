<?php

namespace App\Http\Controllers;

use App\Models\Passager;
use App\Models\Conducteur;
use App\Models\Admin;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // LOGIN FORM
    public function showLogin()
    {
        return view('auth.login');
    }

    // REGISTER FORM
    public function showRegister()
    {
        return view('auth.register');
    }

    // LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $email = $request->email;
        $password = $request->password;

        // Chercher l'utilisateur dans la table utilisateurs
        $utilisateur = Utilisateur::where('email', $email)->first();

        if (!$utilisateur) {
            return back()->with('error', 'Email ou mot de passe incorrect');
        }

        // Vérifier le mot de passe
        if (!$utilisateur->verifierMotDePasse($password)) {
            return back()->with('error', 'Email ou mot de passe incorrect');
        }

        // Déterminer le rôle
        $role = null;
        $user = null;

        if ($utilisateur->admin) {
            $role = 'admin';
            $user = $utilisateur->admin;
        } elseif ($utilisateur->conducteur) {
            $role = 'conducteur';
            $user = $utilisateur->conducteur;
            
            // Vérifier si le conducteur est bloqué
            if (property_exists($user, 'est_bloque') && $user->est_bloque) {
                return back()->with('error', 'Votre compte est bloqué');
            }
        } elseif ($utilisateur->passager) {
            $role = 'passager';
            $user = $utilisateur->passager;
            
            // Vérifier si le passager est bloqué
            if ($user->est_bloque) {
                return back()->with('error', 'Votre compte est bloqué');
            }
        } else {
            return back()->with('error', 'Rôle non défini pour cet utilisateur');
        }

        // Session Laravel
        session([
            'user_id' => $utilisateur->id,
            'role_id' => $user->id,
            'user_role' => $role,
            'user_nom' => $utilisateur->nom,
            'user_email' => $utilisateur->email
        ]);

        // Redirection par rôle
        return match ($role) {
            'admin' => redirect('/admin/dashboard'),
            'conducteur' => redirect('/conducteur/dashboard'),
            default => redirect('/passager/dashboard'),
        };
    }

    // REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:utilisateurs,email',
            'password' => 'required|min:6',
            'telephone' => 'required|string',
            'role' => 'required|in:passager,conducteur'
        ]);

        // Utiliser une transaction pour garantir l'intégrité
        DB::beginTransaction();

        try {
            // 1. Créer l'utilisateur de base
            $utilisateur = Utilisateur::create([
                'nom' => $request->nom,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'telephone' => $request->telephone
            ]);

            // 2. Créer l'entité spécifique (passager ou conducteur)
            if ($request->role === 'passager') {
                $user = Passager::create([
                    'utilisateur_id' => $utilisateur->id,
                    'points_fidelite' => 0,
                    'est_bloque' => false
                ]);
            } else {
                $request->validate([
                    'numero_permis' => 'required|string'
                ]);

                $user = Conducteur::create([
                    'utilisateur_id' => $utilisateur->id,
                    'numero_permis' => $request->numero_permis,
                    'note_moyenne' => 0
                ]);
            }

            DB::commit();

            // Session
            session([
                'user_id' => $utilisateur->id,
                'role_id' => $user->id,
                'user_role' => $request->role,
                'user_nom' => $utilisateur->nom,
                'user_email' => $utilisateur->email
            ]);

            return $request->role === 'conducteur'
                ? redirect('/conducteur/dashboard')
                : redirect('/passager/dashboard');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de l\'inscription : ' . $e->getMessage());
        }
    }

    // LOGOUT
    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }
}