<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Conducteur;
use App\Models\Reservation;
use Illuminate\Http\Request;

class AvisController extends Controller
{
    /* =========================
       AFFICHER AVIS D'UN CONDUCTEUR
    ========================== */
    public function index($conducteurId)
    {
        $conducteur = Conducteur::with('utilisateur')->findOrFail($conducteurId);

        $avis = Avis::where('conducteur_id', $conducteurId)
            ->with(['passager.utilisateur', 'reservation.trajet'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'moyenne' => Avis::where('conducteur_id', $conducteurId)->avg('note') ?? 0,
            'total' => Avis::where('conducteur_id', $conducteurId)->count(),
            'repartition' => [
                5 => Avis::where('conducteur_id', $conducteurId)->where('note', 5)->count(),
                4 => Avis::where('conducteur_id', $conducteurId)->where('note', 4)->count(),
                3 => Avis::where('conducteur_id', $conducteurId)->where('note', 3)->count(),
                2 => Avis::where('conducteur_id', $conducteurId)->where('note', 2)->count(),
                1 => Avis::where('conducteur_id', $conducteurId)->where('note', 1)->count(),
            ]
        ];

        return view('avis.index', compact('conducteur', 'avis', 'stats'));
    }

    /* =========================
       AJOUTER UN AVIS (via reservation)
    ========================== */
    public function store(Request $request, $id)
    {
        $passagerId = session('role_id');
        $userRole = session('user_role');

        if (!$passagerId || $userRole !== 'passager') {
            if ($request->ajax()) {
                return response()->json(['error' => 'Non authentifié'], 401);
            }
            return redirect('/login')->with('error', 'Veuillez vous connecter en tant que passager');
        }

        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:500'
        ]);

        $reservation = Reservation::with('trajet.conducteur')->findOrFail($id);

        if ($reservation->passager_id != $passagerId) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Non autorisé'], 403);
            }
            abort(403);
        }

        if ($reservation->trajet->statut != 'termine') {
            if ($request->ajax()) {
                return response()->json(['error' => 'Le trajet n\'est pas encore terminé'], 400);
            }
            return back()->with('error', 'Le trajet n\'est pas encore terminé');
        }

        $existing = Avis::where('reservation_id', $id)->first();
        if ($existing) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Vous avez déjà noté ce conducteur'], 400);
            }
            return back()->with('error', 'Vous avez déjà noté ce conducteur');
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

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Merci pour votre avis !']);
        }

        return back()->with('success', 'Merci pour votre avis !');
    }

    /* =========================
       MODIFIER UN AVIS (via reservation)
    ========================== */
    public function modifierAvis(Request $request, $reservationId)
    {
        $passagerId = session('role_id');
        $userRole = session('user_role');

        if (!$passagerId || $userRole !== 'passager') {
            if ($request->ajax()) {
                return response()->json(['error' => 'Non authentifié'], 401);
            }
            return redirect('/login')->with('error', 'Veuillez vous connecter');
        }

        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:500'
        ]);

        $avis = Avis::where('reservation_id', $reservationId)
            ->where('passager_id', $passagerId)
            ->first();

        if (!$avis) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Avis non trouvé'], 404);
            }
            return back()->with('error', 'Avis non trouvé');
        }

        $avis->note = $request->note;
        $avis->commentaire = $request->commentaire;
        $avis->save();

        $this->updateConducteurNote($avis->conducteur_id);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Avis modifié avec succès']);
        }

        return back()->with('success', 'Avis modifié avec succès');
    }

    /* =========================
       MES AVIS (CONDUCTEUR)
    ========================== */
    public function mesAvisConducteur()
    {
        $conducteurId = session('role_id');
        $userRole = session('user_role');

        if (!$conducteurId || $userRole !== 'conducteur') {
            return redirect('/login')->with('error', 'Veuillez vous connecter en tant que conducteur');
        }

        $avis = Avis::where('conducteur_id', $conducteurId)
            ->with(['passager.utilisateur', 'reservation.trajet'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $repartition = [];
        for ($i = 1; $i <= 5; $i++) {
            $repartition[$i] = Avis::where('conducteur_id', $conducteurId)->where('note', $i)->count();
        }

        $avisStats = [
            'moyenne' => Avis::where('conducteur_id', $conducteurId)->avg('note') ?? 0,
            'total' => array_sum($repartition),
            'repartition' => $repartition,
        ];

        return view('conducteur.mes-avis', compact('avis', 'avisStats'));
    }

    /* =========================
       UPDATE NOTE CONDUCTEUR
    ========================== */
    private function updateConducteurNote($conducteurId)
    {
        $moyenne = Avis::where('conducteur_id', $conducteurId)->avg('note');
        $conducteur = Conducteur::find($conducteurId);

        if ($conducteur) {
            $conducteur->note_moyenne = round($moyenne, 2);
            $conducteur->save();
        }
    }
}