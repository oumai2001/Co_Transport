<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use App\Models\Passager;
use App\Models\Conducteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Afficher formulaire de connexion
    public function showLogin()
    {
        return view('auth.login');
    }
    
    // Traiter la connexion
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'mot_de_passe' => 'required'
        ]);
        
        $user = Utilisateur::where('email', $request->email)->first();
        
        if ($user && Hash::check($request->mot_de_passe, $user->mot_de_passe)) {
            Auth::login($user);
            
            // Rediriger selon le rôle
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isConducteur()) {
                return redirect()->route('conducteur.dashboard');
            } else {
                return redirect()->route('passager.dashboard');
            }
        }
        
        return back()->withErrors(['email' => 'Email ou mot de passe incorrect']);
    }
    
    // Afficher formulaire d'inscription
    public function showRegister()
    {
        return view('auth.register');
    }
    
    // Traiter l'inscription
    public function register(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:utilisateurs,email',
            'mot_de_passe' => 'required|min:6|confirmed',
            'telephone' => 'nullable|string',
            'type' => 'required|in:passager,conducteur'
        ]);
        
        // Créer l'utilisateur
        $user = Utilisateur::create([
            'nom' => $data['nom'],
            'email' => $data['email'],
            'mot_de_passe' => $data['mot_de_passe'],
            'telephone' => $data['telephone'],
            'type' => $data['type']
        ]);
        
        // Créer le profil spécifique
        if ($data['type'] === 'passager') {
            Passager::create(['utilisateur_id' => $user->id]);
        } else {
            Conducteur::create([
                'utilisateur_id' => $user->id,
                'numero_permis' => 'A_ATTENDRE_' . $user->id
            ]);
        }
        
        Auth::login($user);
        
        // Rediriger selon le rôle
        if ($user->isConducteur()) {
            return redirect()->route('conducteur.dashboard');
        }
        
        return redirect()->route('passager.dashboard');
    }
    
    // Déconnexion
    public function logout()
    {
        Auth::logout();
        return redirect()->route('accueil');
    }
}