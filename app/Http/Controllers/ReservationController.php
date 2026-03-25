<?php

namespace App\Http\Controllers;

use App\Models\Trajet;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    // Créer une réservation (passager)
    public function store(Request $request)
    {
        $user = $request->user();
        
        if ($user->type != 'passager') {
            return response()->json(['message' => 'Seuls les passagers peuvent réserver'], 403);
        }

        $request->validate([
            'trajet_id' => 'required|exists:trajets,id',
            'nombre_places' => 'required|integer|min:1'
        ]);

        $trajet = Trajet::findOrFail($request->trajet_id);

        // Vérifier les places disponibles
        if ($trajet->places_disponibles < $request->nombre_places) {
            return response()->json(['message' => 'Plus de places disponibles'], 400);
        }

        // Vérifier que la date de départ est dans le futur
        if ($trajet->date_depart < now()) {
            return response()->json(['message' => 'Ce trajet est déjà passé'], 400);
        }

        $passager = $user->passager;

        // Créer la réservation
        $reservation = Reservation::create([
            'nombre_places' => $request->nombre_places,
            'prix_unitaire' => $trajet->prix,
            'prix_total' => $trajet->prix * $request->nombre_places,
            'statut' => 'en attente',
            'passager_id' => $passager->id,
            'trajet_id' => $trajet->id
        ]);

        // Réserver les places
        $trajet->places_disponibles -= $request->nombre_places;
        $trajet->save();

        return response()->json($reservation, 201);
    }

    // Annuler une réservation
    public function destroy($id, Request $request)
    {
        $user = $request->user();
        
        if ($user->type != 'passager') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $reservation = Reservation::findOrFail($id);
        
        if ($reservation->passager_id != $user->passager->id) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        // Vérifier que la réservation n'est pas déjà annulée
        if ($reservation->statut == 'annulée') {
            return response()->json(['message' => 'Réservation déjà annulée'], 400);
        }

        // Vérifier que le trajet n'est pas déjà passé
        if ($reservation->trajet->date_depart < now()) {
            return response()->json(['message' => 'Impossible d\'annuler un trajet déjà passé'], 400);
        }

        // Libérer les places
        $trajet = $reservation->trajet;
        $trajet->places_disponibles += $reservation->nombre_places;
        $trajet->save();

        $reservation->statut = 'annulée';
        $reservation->save();

        return response()->json(['message' => 'Réservation annulée']);
    }

    // Mes réservations
    public function mesReservations(Request $request)
    {
        $user = $request->user();
        
        if ($user->type != 'passager') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $reservations = $user->passager->reservations()
                                       ->with('trajet.villeDepart', 'trajet.villeArrivee')
                                       ->orderBy('created_at', 'desc')
                                       ->get();

        return response()->json($reservations);
    }
}