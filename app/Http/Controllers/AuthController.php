<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use App\Models\Passager;
use App\Models\Conducteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // API Register
    public function register(Request $request)
    {
        // Valider les données
        $validator = validator($request->all(), [
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:utilisateurs,email',
            'mot_de_passe' => 'required|min:6|confirmed',
            'telephone' => 'nullable|string',
            'type' => 'required|in:passager,conducteur'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Créer l'utilisateur
        $user = Utilisateur::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'mot_de_passe' => Hash::make($request->mot_de_passe),
            'telephone' => $request->telephone ?? null,
            'type' => $request->type
        ]);
        
        // Créer le profil spécifique
        if ($request->type === 'passager') {
            Passager::create(['utilisateur_id' => $user->id]);
        } else {
            Conducteur::create([
                'utilisateur_id' => $user->id,
                'numero_permis' => 'A_ATTENDRE_' . $user->id
            ]);
        }
        
        // Créer le token
        $token = $user->createToken('auth_token')->plainTextToken;
        
        // Retourner la réponse JSON
        return response()->json([
            'message' => 'Inscription réussie',
            'user' => [
                'id' => $user->id,
                'nom' => $user->nom,
                'email' => $user->email,
                'telephone' => $user->telephone,
                'type' => $user->type,
                'created_at' => $user->created_at
            ],
            'token' => $token
        ], 201);
    }
    
    // API Login (sans session, seulement token)
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'mot_de_passe' => 'required'
        ]);
        
        $user = Utilisateur::where('email', $request->email)->first();
        
        if (!$user || !Hash::check($request->mot_de_passe, $user->mot_de_passe)) {
            return response()->json([
                'message' => 'Email ou mot de passe incorrect'
            ], 401);
        }
        
        // Supprimer les anciens tokens (optionnel)
        $user->tokens()->delete();
        
        // Créer un nouveau token
        $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()->json([
            'message' => 'Connexion réussie',
            'user' => [
                'id' => $user->id,
                'nom' => $user->nom,
                'email' => $user->email,
                'type' => $user->type
            ],
            'token' => $token,
            'type' => $user->type
        ]);
    }
    
    // API Logout
    public function logout(Request $request)
    {
        // Supprimer le token actuel
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'message' => 'Déconnexion réussie'
        ]);
    }
    
    // API Me
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}