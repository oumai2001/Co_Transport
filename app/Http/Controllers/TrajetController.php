<?php

namespace App\Http\Controllers;

use App\Models\Trajet;
use App\Models\Ville;
use Illuminate\Http\Request;

class TrajetController extends Controller
{
    // Liste des trajets (API)
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

        // Retourner JSON pour l'API
        return response()->json($trajets);
    }

    // Détail d'un trajet (API)
    public function show($id)
    {
        $trajet = Trajet::with(['villeDepart', 'villeArrivee', 'conducteur.utilisateur', 'vehicule'])
                        ->findOrFail($id);

        return response()->json($trajet);
    }

    // Créer un trajet (conducteur)
    public function store(Request $request)
    {
        $user = $request->user();
        
        if ($user->type != 'conducteur') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $request->validate([
            'ville_depart_id' => 'required|exists:villes,id',
            'ville_arrivee_id' => 'required|exists:villes,id|different:ville_depart_id',
            'date_depart' => 'required|date|after:now',
            'prix' => 'required|numeric|min:0',
            'places_totales' => 'required|integer|min:1',
            'vehicule_id' => 'nullable|exists:vehicules,id',
        ]);

        $conducteur = $user->conducteur;

        $trajet = $conducteur->trajets()->create([
            'ville_depart_id' => $request->ville_depart_id,
            'ville_arrivee_id' => $request->ville_arrivee_id,
            'date_depart' => $request->date_depart,
            'prix' => $request->prix,
            'places_totales' => $request->places_totales,
            'places_disponibles' => $request->places_totales,
            'vehicule_id' => $request->vehicule_id,
            'statut' => 'programmé'
        ]);

        return response()->json($trajet, 201);
    }

    // Mes trajets (conducteur)
    public function mesTrajets(Request $request)
    {
        $user = $request->user();
        
        if ($user->type != 'conducteur') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $trajets = $user->conducteur->trajets()
                                    ->with(['villeDepart', 'villeArrivee'])
                                    ->orderBy('date_depart', 'desc')
                                    ->get();

        return response()->json($trajets);
    }

    // Mettre à jour un trajet
    public function update(Request $request, $id)
    {
        $trajet = Trajet::findOrFail($id);
        $user = $request->user();

        if ($user->type != 'conducteur' || $trajet->conducteur_id != $user->conducteur->id) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $request->validate([
            'date_depart' => 'sometimes|date',
            'prix' => 'sometimes|numeric|min:0',
            'places_totales' => 'sometimes|integer|min:1',
        ]);

        $trajet->update($request->only(['date_depart', 'prix', 'places_totales']));

        return response()->json($trajet);
    }

    // Annuler un trajet
    public function destroy($id, Request $request)
    {
        $trajet = Trajet::findOrFail($id);
        $user = $request->user();

        if ($user->type != 'conducteur' || $trajet->conducteur_id != $user->conducteur->id) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $trajet->statut = 'annulé';
        $trajet->save();

        return response()->json(['message' => 'Trajet annulé']);
    }
}