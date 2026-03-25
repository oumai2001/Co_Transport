<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehiculeController extends Controller
{
     
    // Liste des véhicules du conducteur connecté
    public function index(Request $request)
    {
        $user = $request->user();
        
        if ($user->type != 'conducteur') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }
        
        $vehicules = $user->conducteur->vehicules;
        
        return response()->json($vehicules);
    }
    
    // Ajouter un véhicule
    public function store(Request $request)
    {
        $user = $request->user();
        
        if ($user->type != 'conducteur') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }
        
        $request->validate([
            'immatriculation' => 'required|unique:vehicules',
            'marque' => 'required|string',
            'modele' => 'required|string',
            'capacite' => 'required|integer|min:1',
            'annee' => 'nullable|integer',
            'couleur' => 'nullable|string',
            'statut' => 'nullable|in:disponible,maintenance,en trajet'
        ]);
        
        $conducteur = $user->conducteur;
        
        $vehicule = $conducteur->vehicules()->create([
            'immatriculation' => $request->immatriculation,
            'marque' => $request->marque,
            'modele' => $request->modele,
            'capacite' => $request->capacite,
            'annee' => $request->annee,
            'couleur' => $request->couleur,
            'statut' => $request->statut ?? 'disponible'
        ]);
        
        return response()->json($vehicule, 201);
    }
    
    // Modifier un véhicule
    public function update(Request $request, $id)
    {
        $user = $request->user();
        
        if ($user->type != 'conducteur') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }
        
        $vehicule = Vehicule::findOrFail($id);
        
        if ($vehicule->conducteur_id != $user->conducteur->id) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }
        
        $request->validate([
            'marque' => 'sometimes|string',
            'modele' => 'sometimes|string',
            'capacite' => 'sometimes|integer|min:1',
            'annee' => 'nullable|integer',
            'couleur' => 'nullable|string',
            'statut' => 'nullable|in:disponible,maintenance,en trajet'
        ]);
        
        $vehicule->update($request->only(['marque', 'modele', 'capacite', 'annee', 'couleur', 'statut']));
        
        return response()->json($vehicule);
    }
    
    // Supprimer un véhicule
    public function destroy($id, Request $request)
    {
        $user = $request->user();
        
        if ($user->type != 'conducteur') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }
        
        $vehicule = Vehicule::findOrFail($id);
        
        if ($vehicule->conducteur_id != $user->conducteur->id) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }
        
        $vehicule->delete();
        
        return response()->json(['message' => 'Véhicule supprimé avec succès']);
    }
}