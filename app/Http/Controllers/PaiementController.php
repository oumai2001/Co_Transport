<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Paiement;
use App\Models\Transaction;
use App\Models\Trajet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaiementController extends Controller
{
    public function show($reservation_id)
    {
        $passagerId = session('role_id');
        $userRole = session('user_role');

        if (!$passagerId || $userRole !== 'passager') {
            return redirect('/login')->with('error', 'Veuillez vous connecter en tant que passager');
        }

        $reservation = Reservation::with([
            'trajet' => function($q) {
                $q->with(['villeDepart', 'villeArrivee', 'conducteur.utilisateur']);
            }
        ])->findOrFail($reservation_id);

        if ($reservation->passager_id != $passagerId) {
            abort(403);
        }

        if ($reservation->statut != 'en_attente') {
            return redirect('/passager/historique')->with('error', 'Réservation non payable');
        }

        return view('paiement.index', compact('reservation'));
    }

    public function effectuer($reservation_id, Request $request)
    {
        $passagerId = session('role_id');
        if (session('user_role') !== 'passager') {
            return redirect('/login')->with('error', 'Connectez-vous en tant que passager');
        }

        $request->validate([
            'mode_paiement' => 'required|in:carte,especes'
        ]);

        DB::beginTransaction();

        try {
            $reservation = Reservation::with('trajet')->findOrFail($reservation_id);

            if ($reservation->passager_id != $passagerId) {
                throw new \Exception('Réservation non autorisée');
            }

            if ($reservation->statut !== 'en_attente') {
                throw new \Exception('Réservation déjà payée ou annulée');
            }

            $trajet = $reservation->trajet;
            if ($trajet->places_disponibles < $reservation->nombre_places) {
                throw new \Exception('Plus assez de places disponibles');
            }

            // Créer le paiement
            $paiement = Paiement::create([
                'reservation_id' => $reservation_id,
                'montant' => $reservation->prix_total,
                'date_paiement' => now(),
                'mode_paiement' => $request->mode_paiement,
                'statut' => 'paye'
            ]);

            // Confirmer la réservation
            $reservation->statut = 'confirmee';
            $reservation->save();

            // Décrémenter les places
            $trajet->places_disponibles -= $reservation->nombre_places;
            $trajet->save();

            // Créer la transaction
            Transaction::create([
                'passager_id' => $passagerId,
                'paiement_id' => $paiement->id,
                'montant' => $reservation->prix_total,
                'type' => 'depense',
                'statut' => 'complete',
                'description' => "Paiement réservation #{$reservation->id}",
                'date_creation' => now()
            ]);

            DB::commit();

            return redirect('/passager/historique')->with('success', 'Paiement effectué avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    public function historique()
    {
        $passagerId = session('role_id');
        if (session('user_role') !== 'passager') {
            return redirect('/login')->with('error', 'Accès non autorisé');
        }

        $transactions = Transaction::where('passager_id', $passagerId)
            ->with('paiement.reservation.trajet')
            ->orderBy('date_creation', 'desc')
            ->paginate(20);

        $solde = Transaction::where('passager_id', $passagerId)
            ->where('statut', 'complete')
            ->selectRaw("SUM(CASE WHEN type = 'depense' THEN -montant ELSE montant END) as solde")
            ->value('solde') ?? 0;

        return view('paiement.historique', compact('transactions', 'solde'));
    }
}