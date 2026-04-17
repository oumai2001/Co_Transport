<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Trajet;
use App\Models\Avis;
use App\Models\Conducteur;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    /* =========================
        RÉSERVER 
    ========================= */
    public function reserver($trajet_id)
    {
        $passagerId = session('role_id');
        $userRole = session('user_role');

        if (!$passagerId || $userRole !== 'passager') {
            return redirect('/login')->with('error', 'Veuillez vous connecter en tant que passager');
        }

        $trajet = Trajet::findOrFail($trajet_id);

        if ($trajet->statut !== 'programme') {
            return back()->with('error', 'Ce trajet n\'est plus disponible');
        }

        if ($trajet->date_depart < now()) {
            return back()->with('error', 'Ce trajet a déjà commencé');
        }

        if ($trajet->places_disponibles < 1) {
            return back()->with('error', 'Plus de places disponibles');
        }

        $existing = Reservation::where('passager_id', $passagerId)
            ->where('trajet_id', $trajet_id)
            ->whereIn('statut', ['confirmee', 'en_attente'])
            ->exists();

        if ($existing) {
            return back()->with('error', 'Vous avez déjà réservé ce trajet');
        }

        DB::beginTransaction();

        try {
            $reservation = Reservation::create([
                'passager_id' => $passagerId,
                'trajet_id' => $trajet_id,
                'nombre_places' => 1,
                'prix_total' => $trajet->prix,
                'statut' => 'en_attente',
                'date_reservation' => now()
            ]);

            DB::commit();

            return redirect()->route('paiement.show', $reservation->id)
                ->with('success', 'Réservation créée ! Veuillez procéder au paiement.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la réservation');
        }
    }

    /* =========================
        RÉSERVATION MULTIPLE PLACES
    ========================= */
    public function confirmer(Request $request, $trajet_id)
    {
        $passagerId = session('role_id');
        $userRole = session('user_role');

        if (!$passagerId || $userRole !== 'passager') {
            return redirect('/login')->with('error', 'Veuillez vous connecter en tant que passager');
        }

        $request->validate([
            'nombre_places' => 'required|integer|min:1|max:9'
        ]);

        $trajet = Trajet::findOrFail($trajet_id);

        if ($trajet->statut !== 'programme') {
            return back()->with('error', 'Ce trajet n\'est plus disponible');
        }

        if ($trajet->date_depart < now()) {
            return back()->with('error', 'Ce trajet a déjà commencé');
        }

        if ($trajet->places_disponibles < $request->nombre_places) {
            return back()->with('error', 'Plus assez de places disponibles');
        }

        $existing = Reservation::where('passager_id', $passagerId)
            ->where('trajet_id', $trajet_id)
            ->whereIn('statut', ['confirmee', 'en_attente'])
            ->exists();

        if ($existing) {
            return back()->with('error', 'Vous avez déjà réservé ce trajet');
        }

        DB::beginTransaction();

        try {
            $reservation = Reservation::create([
                'passager_id' => $passagerId,
                'trajet_id' => $trajet_id,
                'nombre_places' => $request->nombre_places,
                'prix_total' => $trajet->prix * $request->nombre_places,
                'statut' => 'en_attente',
                'date_reservation' => now()
            ]);

            DB::commit();

            return redirect()->route('paiement.show', $reservation->id)
                ->with('success', 'Réservation créée ! Veuillez procéder au paiement.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la réservation');
        }
    }

    /* =========================
        ANNULER RÉSERVATION
    ========================= */
    public function annuler($id)
    {
        $passagerId = session('role_id');
        $userRole = session('user_role');

        if (!$passagerId || $userRole !== 'passager') {
            return redirect('/login')->with('error', 'Veuillez vous connecter');
        }

        DB::beginTransaction();

        try {
            $reservation = Reservation::with('trajet')->findOrFail($id);

            if ($reservation->passager_id != $passagerId) {
                abort(403, 'Accès non autorisé');
            }

            if ($reservation->trajet->date_depart < now()) {
                return back()->with('error', 'Impossible d\'annuler un trajet déjà commencé');
            }

            if ($reservation->statut === 'annulee') {
                return back()->with('error', 'Cette réservation est déjà annulée');
            }

            if ($reservation->statut === 'confirmee') {
                $trajet = $reservation->trajet;
                $trajet->places_disponibles += $reservation->nombre_places;
                $trajet->save();
            }

            $reservation->statut = 'annulee';
            $reservation->save();

            DB::commit();

            return back()->with('success', 'Réservation annulée avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de l\'annulation');
        }
    }

    /* =========================
        HISTORIQUE DES RÉSERVATIONS
    ========================= */
    public function historique()
    {
        $passagerId = session('role_id');
        $userRole = session('user_role');

        if (!$passagerId || $userRole !== 'passager') {
            return redirect('/login')->with('error', 'Veuillez vous connecter');
        }

        $reservations = Reservation::where('passager_id', $passagerId)
            ->with([
                'trajet' => function($q) {
                    $q->with(['villeDepart', 'villeArrivee', 'conducteur.utilisateur']);
                },
                'paiement'
            ])
            ->orderBy('date_reservation', 'desc')
            ->paginate(15);

        return view('passager.historique', compact('reservations'));
    }

    /* =========================
        NOTER LE CONDUCTEUR 
    ========================= */
    public function noterConducteur(Request $request, $id)
    {
        $passagerId = session('role_id');
        $userRole = session('user_role');

        if (!$passagerId || $userRole !== 'passager') {
            return response()->json(['error' => 'Non authentifié'], 401);
        }

        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();

        try {
            $reservation = Reservation::with('trajet.conducteur')->findOrFail($id);

            if ($reservation->passager_id != $passagerId) {
                return response()->json(['error' => 'Non autorisé'], 403);
            }

            if ($reservation->trajet->statut != 'termine') {
                return response()->json(['error' => 'Le trajet n\'est pas encore terminé'], 400);
            }

            $avisExistant = Avis::where('reservation_id', $id)->first();
            if ($avisExistant) {
                return response()->json(['error' => 'Vous avez déjà noté ce conducteur'], 400);
            }

            Avis::create([
                'reservation_id' => $id,
                'passager_id' => $passagerId,
                'conducteur_id' => $reservation->trajet->conducteur_id,
                'note' => $request->note,
                'commentaire' => $request->commentaire,
                'signale' => false,
            ]);

            $this->updateConducteurNote($reservation->trajet->conducteur_id);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Merci pour votre avis !']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erreur lors de l\'enregistrement'], 500);
        }
    }

    /* =========================
        MODIFIER UN AVIS 
    ========================= */
    public function modifierAvis(Request $request, $reservationId)
    {
        $passagerId = session('role_id');
        $userRole = session('user_role');

        if (!$passagerId || $userRole !== 'passager') {
            return response()->json(['error' => 'Non authentifié'], 401);
        }

        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();

        try {
            $avis = Avis::where('reservation_id', $reservationId)
                ->where('passager_id', $passagerId)
                ->first();

            if (!$avis) {
                return response()->json(['error' => 'Avis non trouvé'], 404);
            }

            $avis->note = $request->note;
            $avis->commentaire = $request->commentaire;
            $avis->save();

            $this->updateConducteurNote($avis->conducteur_id);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Avis modifié avec succès']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erreur lors de la modification'], 500);
        }
    }

    /* =========================
        MISE À JOUR DE LA NOTE DU CONDUCTEUR
    ========================= */
    private function updateConducteurNote($conducteurId)
    {
        $moyenne = Avis::where('conducteur_id', $conducteurId)->avg('note');
        $conducteur = Conducteur::find($conducteurId);
        
        if ($conducteur) {
            $conducteur->note_moyenne = round($moyenne, 2);
            $conducteur->save();
        }
    
}
public function showReservationForm($trajet_id)
{
    // 1. Vérification de l’authentification
    if (!session('role_id') || session('user_role') !== 'passager') {
        return redirect('/login')->with('error', 'Connectez-vous en tant que passager');
    }

    // 2. Récupération du trajet
    $trajet = Trajet::with(['villeDepart', 'villeArrivee', 'conducteur.utilisateur'])->findOrFail($trajet_id);

    // 3. Vérifications de disponibilité
    if ($trajet->statut !== 'programme') {
        return redirect('/trajets')->with('error', 'Ce trajet n\'est pas disponible');
    }
    if ($trajet->date_depart <= now()) {
        return redirect('/trajets')->with('error', 'Ce trajet a déjà commencé');
    }
    if ($trajet->places_disponibles <= 0) {
        return redirect('/trajets')->with('error', 'Plus de places disponibles');
    }

    // 4. Afficher la vue
    return view('reservation.confirmation', compact('trajet'));
}
}