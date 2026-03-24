<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehiculeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:conducteur');
    }
    
    // Liste des véhicules
    public function index()
    {
        $vehicules = Auth::user()->conducteur->vehicules;
        return view('vehicules.index', compact('vehicules'));
    }
    
    // Formulaire d'ajout
    public function create()
    {
        return view('vehicules.create');
    }
    
    // Ajouter un véhicule
    public function store(Request $request)
    {
        $data = $request->validate([
            'immatriculation' => 'required|unique:vehicules',
            'marque' => 'required|string',
            'modele' => 'required|string',
            'capacite' => 'required|integer|min:1',
            'annee' => 'nullable|integer|min:1900',
            'couleur' => 'nullable|string',
        ]);
        
        $conducteur = Auth::user()->conducteur;
        
        $vehicule = $conducteur->vehicules()->create($data);
        
        return redirect()->route('vehicules.index')
                         ->with('success', 'Véhicule ajouté avec succès');
    }
    
    // Modifier un véhicule
    public function edit(Vehicule $vehicule)
    {
        $this->authorize('update', $vehicule);
        
        return view('vehicules.edit', compact('vehicule'));
    }
    
    // Mettre à jour
    public function update(Request $request, Vehicule $vehicule)
    {
        $this->authorize('update', $vehicule);
        
        $data = $request->validate([
            'marque' => 'required|string',
            'modele' => 'required|string',
            'capacite' => 'required|integer|min:1',
            'annee' => 'nullable|integer',
            'couleur' => 'nullable|string',
        ]);
        
        $vehicule->update($data);
        
        return redirect()->route('vehicules.index')
                         ->with('success', 'Véhicule modifié');
    }
    
    // Supprimer
    public function destroy(Vehicule $vehicule)
    {
        $this->authorize('delete', $vehicule);
        
        $vehicule->delete();
        
        return redirect()->route('vehicules.index')
                         ->with('success', 'Véhicule supprimé');
    }
}