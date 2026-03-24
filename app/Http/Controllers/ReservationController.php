<?php

namespace App\Http\Controllers;

use App\Models\Trajet;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:passager');
    }
    
    // Créer une réservation
    public function store(Request $request, Trajet $trajet)
    {
        $data = $request->validate([
            'nombre_places' => 'required|integer|min:1|max:' . $trajet->places_disponibles
        ]);
        
        // Vérifier les places
        if (!$trajet->restePlaces()) {
            return back()->with('error', 'Plus de places disponibles');
        }
        
        $passager = Auth::user()->passager;
        
        // Créer la réservation
        $reservation = Reservation::create([
            'nombre_places' => $data['nombre_places'],
            'prix_unitaire' => $trajet->prix,
            'prix_total' => $trajet->prix * $data['nombre_places'],
            'statut' => 'en attente',
            'passager_id' => $passager->id,
            'trajet_id' => $trajet->id
        ]);
        
        // Réserver les places
        $trajet->reserverPlaces($data['nombre_places']);
        
        return redirect()->route('paiement.create', $reservation)
                         ->with('success', 'Réservation créée, veuillez payer');
    }
    
    // Annuler une réservation
    public function destroy(Reservation $reservation)
    {
        $this->authorize('delete', $reservation);
        
        $reservation->annuler();
        
        return redirect()->back()->with('success', 'Réservation annulée');
    }
}