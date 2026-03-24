<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaiementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:passager');
    }
    
    // Formulaire de paiement
    public function create(Reservation $reservation)
    {
        $this->authorize('update', $reservation);
        
        return view('paiement.create', compact('reservation'));
    }
    
    // Traiter le paiement
    public function store(Request $request, Reservation $reservation)
    {
        $this->authorize('update', $reservation);
        
        $data = $request->validate([
            'mode_paiement' => 'required|in:carte,espèces'
        ]);
        
        // Créer le paiement
        $paiement = Paiement::create([
            'montant' => $reservation->prix_total,
            'mode_paiement' => $data['mode_paiement'],
            'statut' => 'payé',
            'transaction_id' => 'TRX_' . time() . '_' . $reservation->id,
            'reservation_id' => $reservation->id
        ]);
        
        // Valider la réservation
        $reservation->confirmer();
        
        return redirect()->route('passager.dashboard')
                         ->with('success', 'Paiement effectué avec succès');
    }
}