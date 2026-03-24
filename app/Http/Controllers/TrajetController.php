<?php

namespace App\Http\Controllers;

use App\Models\Trajet;
use App\Models\Ville;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrajetController extends Controller
{
    // Liste des trajets (public)
    public function index(Request $request)
    {
        $query = Trajet::with(['villeDepart', 'villeArrivee', 'conducteur.utilisateur'])
                      ->where('date_depart', '>', now())
                      ->where('places_disponibles', '>', 0)
                      ->where('statut', 'programmé');
        
        // Filtres
        if ($request->depart) {
            $query->where('ville_depart_id', $request->depart);
        }
        
        if ($request->arrivee) {
            $query->where('ville_arrivee_id', $request->arrivee);
        }
        
        if ($request->date) {
            $query->whereDate('date_depart', $request->date);
        }
        
        $trajets = $query->orderBy('date_depart')->paginate(10);
        $villes = Ville::all();
        
        return view('trajets.index', compact('trajets', 'villes'));
    }
    
    // Détail d'un trajet
    public function show(Trajet $trajet)
    {
        $trajet->load(['villeDepart', 'villeArrivee', 'conducteur.utilisateur', 'vehicule']);
        
        return view('trajets.show', compact('trajet'));
    }
    
    // Formulaire de création (conducteur)
    public function create()
    {
        $villes = Ville::all();
        $vehicules = Auth::user()->conducteur->vehicules;
        
        return view('trajets.create', compact('villes', 'vehicules'));
    }
    
    // Enregistrer un trajet
    public function store(Request $request)
    {
        $data = $request->validate([
            'ville_depart_id' => 'required|exists:villes,id',
            'ville_arrivee_id' => 'required|exists:villes,id|different:ville_depart_id',
            'date_depart' => 'required|date|after:now',
            'date_arrivee' => 'nullable|date|after:date_depart',
            'prix' => 'required|numeric|min:0',
            'places_totales' => 'required|integer|min:1',
            'vehicule_id' => 'nullable|exists:vehicules,id',
            'adresse_depart' => 'nullable|string',
            'adresse_arrivee' => 'nullable|string',
        ]);
        
        $conducteur = Auth::user()->conducteur;
        
        $trajet = $conducteur->trajets()->create([
            'ville_depart_id' => $data['ville_depart_id'],
            'ville_arrivee_id' => $data['ville_arrivee_id'],
            'adresse_depart' => $data['adresse_depart'],
            'adresse_arrivee' => $data['adresse_arrivee'],
            'date_depart' => $data['date_depart'],
            'date_arrivee' => $data['date_arrivee'],
            'prix' => $data['prix'],
            'places_totales' => $data['places_totales'],
            'places_disponibles' => $data['places_totales'],
            'vehicule_id' => $data['vehicule_id'],
            'statut' => 'programmé'
        ]);
        
        return redirect()->route('conducteur.dashboard')
                         ->with('success', 'Trajet créé avec succès');
    }
    
    // Modifier un trajet
    public function edit(Trajet $trajet)
    {
        $this->authorize('update', $trajet);
        
        $villes = Ville::all();
        $vehicules = Auth::user()->conducteur->vehicules;
        
        return view('trajets.edit', compact('trajet', 'villes', 'vehicules'));
    }
    
    // Mettre à jour un trajet
    public function update(Request $request, Trajet $trajet)
    {
        $this->authorize('update', $trajet);
        
        $data = $request->validate([
            'ville_depart_id' => 'required|exists:villes,id',
            'ville_arrivee_id' => 'required|exists:villes,id|different:ville_depart_id',
            'date_depart' => 'required|date',
            'prix' => 'required|numeric|min:0',
            'places_totales' => 'required|integer|min:1',
        ]);
        
        $differencePlaces = $data['places_totales'] - $trajet->places_totales;
        $trajet->places_disponibles += $differencePlaces;
        
        $trajet->update($data);
        
        return redirect()->route('conducteur.dashboard')
                         ->with('success', 'Trajet modifié avec succès');
    }
    
    // Annuler un trajet
    public function destroy(Trajet $trajet)
    {
        $this->authorize('delete', $trajet);
        
        $trajet->statut = 'annulé';
        $trajet->save();
        
        return redirect()->route('conducteur.dashboard')
                         ->with('success', 'Trajet annulé');
    }
    
    // Mettre à jour le statut
    public function updateStatut(Request $request, Trajet $trajet)
    {
        $this->authorize('update', $trajet);
        
        $request->validate([
            'statut' => 'required|in:programmé,en cours,terminé,annulé'
        ]);
        
        $trajet->statut = $request->statut;
        $trajet->save();
        
        return redirect()->back()->with('success', 'Statut mis à jour');
    }
}