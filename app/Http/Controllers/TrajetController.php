<?php

namespace App\Http\Controllers;

use App\Models\Trajet;
use App\Models\Ville;
use App\Models\Vehicule;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrajetController extends Controller
{
    /* =========================
        LISTE DES TRAJETS
    ========================= */
public function index(Request $request)
{
    $villes = Ville::orderBy('nom')->get();

    // Requête de base
    $query = Trajet::where('statut', 'programme')
        ->where('date_depart', '>', now())
        ->where('places_disponibles', '>', 0)
        ->with([
            'villeDepart',
            'villeArrivee',
            'conducteur.utilisateur',
            'vehicule'
        ]);

    // ⭐ Filtre par conducteur (AJOUTÉ)
    if ($request->filled('conducteur_id')) {
        $query->where('conducteur_id', $request->conducteur_id);
    }

    // Filtres existants
    if ($request->filled('ville_depart')) {
        $query->where('ville_depart_id', $request->ville_depart);
    }

    if ($request->filled('ville_arrivee')) {
        $query->where('ville_arrivee_id', $request->ville_arrivee);
    }

    if ($request->filled('date_depart')) {
        $query->whereDate('date_depart', $request->date_depart);
    }

    $trajets = $query->orderBy('date_depart', 'asc')->get();

    // Vérifier les réservations du passager connecté
    if (session('user_role') == 'passager') {
        $passagerId = session('role_id');
        $reservations = Reservation::where('passager_id', $passagerId)
            ->whereIn('statut', ['confirmee', 'en_attente'])
            ->get()
            ->keyBy('trajet_id');

        foreach ($trajets as $trajet) {
            $trajet->reservation_passager = $reservations->get($trajet->id);
        }
    }

    return view('trajets.index', compact('trajets', 'villes'));
}
    /* =========================
        FILTRER TRAJETS 
    ========================= */
    public function filtrer(Request $request)
    {
        $query = Trajet::where('statut', 'programme')
            ->where('date_depart', '>', now())
            ->where('places_disponibles', '>', 0)
            ->with([
                'villeDepart', 
                'villeArrivee', 
                'conducteur.utilisateur',
                'vehicule'
            ]);

        if ($request->filled('ville_depart')) {
            $query->where('ville_depart_id', $request->ville_depart);
        }

        if ($request->filled('ville_arrivee')) {
            $query->where('ville_arrivee_id', $request->ville_arrivee);
        }

        if ($request->filled('date_depart')) {
            $query->whereDate('date_depart', $request->date_depart);
        }

        $trajets = $query->orderBy('date_depart', 'asc')->get();
        $villes = Ville::orderBy('nom')->get();

        return view('trajets.index', compact('trajets', 'villes'));
    }

    /* =========================
        DÉTAILS D'UN TRAJET
    ========================= */
    public function show($id)
    {
        $trajet = Trajet::with([
            'villeDepart',
            'villeArrivee',
            'conducteur.utilisateur',
            'vehicule'
        ])->findOrFail($id);

        $passagerId = session('role_id');
        $userRole = session('user_role');

        $dejaReserve = false;
        $reservationExistante = null;

        if ($passagerId && $userRole === 'passager') {
            $reservationExistante = Reservation::where('passager_id', $passagerId)
                ->where('trajet_id', $id)
                ->whereIn('statut', ['confirmee', 'en_attente'])
                ->first();

            $dejaReserve = $reservationExistante ? true : false;
        }

        return view('trajets.show', compact(
            'trajet',
            'dejaReserve',
            'reservationExistante'
        ));
    }

    /* =========================
        FORMULAIRE CRÉATION TRAJET
    ========================= */
    public function create()
    {
        $conducteurId = session('role_id');
        $userRole = session('user_role');

        if (!$conducteurId || $userRole !== 'conducteur') {
            return redirect('/login')->with('error', 'Veuillez vous connecter en tant que conducteur');
        }

        $vehicules = Vehicule::where('conducteur_id', $conducteurId)
            ->where('statut', 'disponible')
            ->get();
            
        $villes = Ville::orderBy('nom')->get();

        if ($vehicules->isEmpty()) {
            return redirect('/conducteur/vehicules')
                ->with('error', 'Ajoutez d\'abord un véhicule disponible');
        }

        return view('conducteur.creer-trajet', compact('vehicules', 'villes'));
    }

    /* =========================
        ENREGISTRER TRAJET
    ========================= */
    public function store(Request $request)
    {
        $conducteurId = session('role_id');
        $userRole = session('user_role');

        if (!$conducteurId || $userRole !== 'conducteur') {
            return redirect('/login')->with('error', 'Veuillez vous connecter en tant que conducteur');
        }

        $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'ville_depart' => 'required|exists:villes,id',
            'ville_arrivee' => 'required|exists:villes,id|different:ville_depart',
            'date_depart' => 'required|date|after:now',
            'date_arrivee' => 'required|date|after:date_depart',
            'prix' => 'required|numeric|min:0',
            'places_disponibles' => 'required|integer|min:1|max:10',
        ]);

        DB::beginTransaction();

        try {
            $trajet = Trajet::create([
                'conducteur_id' => $conducteurId,
                'vehicule_id' => $request->vehicule_id,
                'ville_depart_id' => $request->ville_depart,
                'ville_arrivee_id' => $request->ville_arrivee,
                'date_depart' => $request->date_depart,
                'date_arrivee' => $request->date_arrivee,
                'prix' => $request->prix,
                'places_disponibles' => $request->places_disponibles,
                'statut' => 'en_attente', 
            ]);

            DB::commit();

             return redirect('/conducteur/mes-trajets')
        ->with('success', 'Trajet créé avec succès. En attente de validation par l\'administrateur.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la création');
        }
    }

    /* =========================
        MES TRAJETS (CONDUCTEUR)
    ========================= */
    public function mesTrajets()
    {
        $conducteurId = session('role_id');
        $userRole = session('user_role');

        if (!$conducteurId || $userRole !== 'conducteur') {
            return redirect('/login')->with('error', 'Veuillez vous connecter en tant que conducteur');
        }

        $trajets = Trajet::where('conducteur_id', $conducteurId)
            ->with(['villeDepart', 'villeArrivee', 'vehicule'])
            ->orderBy('date_depart', 'desc')
            ->get();

        return view('conducteur.mes-trajets', compact('trajets'));
    }

    /* =========================
        MODIFIER TRAJET 
    ========================= */
    public function edit($id)
    {
        $conducteurId = session('role_id');
        $userRole = session('user_role');

        if (!$conducteurId || $userRole !== 'conducteur') {
            return redirect('/login')->with('error', 'Veuillez vous connecter en tant que conducteur');
        }

        $trajet = Trajet::where('conducteur_id', $conducteurId)
            ->where('id', $id)
            ->firstOrFail();

        if ($trajet->statut !== 'programme') {
            return back()->with('error', 'Seuls les trajets programmés peuvent être modifiés');
        }

        $vehicules = Vehicule::where('conducteur_id', $conducteurId)->get();
        $villes = Ville::orderBy('nom')->get();

        return view('conducteur.modifier-trajet', compact('trajet', 'vehicules', 'villes'));
    }

    /* =========================
        METTRE À JOUR TRAJET
    ========================= */
    public function update(Request $request, $id)
    {
        $conducteurId = session('role_id');
        $userRole = session('user_role');

        if (!$conducteurId || $userRole !== 'conducteur') {
            return redirect('/login')->with('error', 'Veuillez vous connecter en tant que conducteur');
        }

        $trajet = Trajet::where('conducteur_id', $conducteurId)
            ->where('id', $id)
            ->firstOrFail();

        if ($trajet->statut !== 'programme') {
            return back()->with('error', 'Seuls les trajets programmés peuvent être modifiés');
        }

        $request->validate([
            'ville_depart' => 'required|exists:villes,id',
            'ville_arrivee' => 'required|exists:villes,id|different:ville_depart',
            'date_depart' => 'required|date|after:now',
            'date_arrivee' => 'required|date|after:date_depart',
            'prix' => 'required|numeric|min:0',
            'places_disponibles' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $trajet->update([
                'ville_depart_id' => $request->ville_depart,
                'ville_arrivee_id' => $request->ville_arrivee,
                'date_depart' => $request->date_depart,
                'date_arrivee' => $request->date_arrivee,
                'prix' => $request->prix,
                'places_disponibles' => $request->places_disponibles,
            ]);

            DB::commit();

            return redirect('/conducteur/mes-trajets')
                ->with('success', 'Trajet modifié avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la modification');
        }
    }

    /* =========================
        SUPPRIMER TRAJET
    ========================= */
    public function destroy($id)
    {
        $userRole = session('user_role');
        $conducteurId = session('role_id');

        $trajet = Trajet::findOrFail($id);

        if ($userRole !== 'admin' && $trajet->conducteur_id != $conducteurId) {
            abort(403, 'Accès non autorisé');
        }

        $trajet->delete();

        return back()->with('success', 'Trajet supprimé avec succès');
    }

    /* =========================
        PASSAGERS D'UN TRAJET
    ========================= */
public function voirPassagers($id)
{
    $conducteurId = session('role_id');
    $userRole = session('user_role');

    if (!$conducteurId || $userRole !== 'conducteur') {
        return redirect('/login')->with('error', 'Veuillez vous connecter en tant que conducteur');
    }

    $trajet = Trajet::where('conducteur_id', $conducteurId)
        ->with([
            'villeDepart', 
            'villeArrivee',
            'vehicule'
        ])
        ->findOrFail($id);

    //  Récupérer les réservations confirmées (retourne une collection vide si rien)
    $reservations = Reservation::where('trajet_id', $id)
        ->where('statut', 'confirmee')
        ->with(['passager.utilisateur', 'paiement'])
        ->get();  // Toujours une collection, même vide

    return view('conducteur.passagers', compact('trajet', 'reservations'));
}

    /* =========================
        METTRE À JOUR STATUT (AJAX)
    ========================= */
    public function mettreAJourStatut(Request $request, $id)
    {
        $conducteurId = session('role_id');
        $userRole = session('user_role');

        if (!$conducteurId || $userRole !== 'conducteur') {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $trajet = Trajet::where('conducteur_id', $conducteurId)
            ->where('id', $id)
            ->firstOrFail();

        $valid = ['programme', 'en_cours', 'termine', 'annule'];

        if (!in_array($request->statut, $valid)) {
            return response()->json(['error' => 'Statut invalide'], 400);
        }

        $trajet->statut = $request->statut;
        $trajet->save();

        return response()->json([
            'success' => true,
            'statut' => $trajet->statut
        ]);
    }

    /* =========================
        RECHERCHE JSON (AJAX)
    ========================= */
    public function rechercheJSON(Request $request)
    {
        $query = Trajet::where('statut', 'programme')
            ->where('date_depart', '>', now())
            ->where('places_disponibles', '>', 0)
            ->with([
                'villeDepart', 
                'villeArrivee', 
                'conducteur.utilisateur'
            ]);

        if ($request->filled('ville_depart')) {
            $query->where('ville_depart_id', $request->ville_depart);
        }

        if ($request->filled('ville_arrivee')) {
            $query->where('ville_arrivee_id', $request->ville_arrivee);
        }

        $trajets = $query->orderBy('date_depart', 'asc')->limit(50)->get();

        return response()->json(
            $trajets->map(function ($t) {
                return [
                    'id' => $t->id,
                    'depart' => $t->villeDepart->nom ?? '',
                    'arrivee' => $t->villeArrivee->nom ?? '',
                    'date_depart' => $t->date_depart->format('d/m/Y H:i'),
                    'prix' => $t->prix,
                    'places' => $t->places_disponibles,
                    'conducteur' => $t->conducteur->utilisateur->nom ?? '',
                ];
            })
        );
    }
}