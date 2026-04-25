<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Conducteur;
use App\Models\Trajet;
use App\Models\Vehicule;
use App\Models\Reservation;
use App\Models\Ville;
use App\Models\Utilisateur;

class ConducteurController extends Controller
{
    //DASHBOARD

    public function dashboard()
    {
        $conducteurId = session('role_id');
        $userId = session('user_id');
        
        if (!$conducteurId || session('user_role') !== 'conducteur') {
            if ($userId) {
                $conducteur = Conducteur::where('utilisateur_id', $userId)->first();
                if ($conducteur) {
                    $conducteurId = $conducteur->id;
                    session(['role_id' => $conducteurId]);
                }
            }
        }
        
        if (!$conducteurId) {
            return redirect('/login')->with('error', 'Veuillez vous connecter en tant que conducteur');
        }
        
        $conducteur = Conducteur::with('utilisateur')->findOrFail($conducteurId);

        $stats = [
            'total_trajets' => Trajet::where('conducteur_id', $conducteurId)->count(),
            'total_passagers' => Reservation::whereHas('trajet', function ($q) use ($conducteurId) {
                $q->where('conducteur_id', $conducteurId);
            })->where('statut', 'confirmee')->count(),
            'gains_totaux' => Reservation::whereHas('trajet', function ($q) use ($conducteurId) {
                $q->where('conducteur_id', $conducteurId);
            })->where('statut', 'confirmee')->sum('prix_total') ?? 0,
            'note_moyenne' => round($conducteur->note_moyenne ?? 0, 2),
        ];

        $prochains_trajets = Trajet::where('conducteur_id', $conducteurId)
            ->where('date_depart', '>', now())
            ->where('statut', 'programme')
            ->with(['villeDepart', 'villeArrivee', 'vehicule'])
            ->orderBy('date_depart', 'asc')
            ->limit(5)
            ->get();

        $dernieres_reservations = Reservation::whereHas('trajet', function ($q) use ($conducteurId) {
            $q->where('conducteur_id', $conducteurId);
        })
        ->with(['passager.utilisateur', 'trajet'])
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

        return view('conducteur.dashboard', compact(
            'conducteur',
            'stats',
            'prochains_trajets',
            'dernieres_reservations'
        ));
    }

    // CREER TRAJET
    public function creerTrajet()
    {
        $conducteurId = session('role_id');
        
        if (!$conducteurId || session('user_role') !== 'conducteur') {
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

    // STORE TRAJET
    public function storeTrajet(Request $request)
    {
        $conducteurId = session('role_id');
        
        if (!$conducteurId || session('user_role') !== 'conducteur') {
            return redirect('/login')->with('error', 'Veuillez vous connecter en tant que conducteur');
        }

        $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'ville_depart' => 'required|exists:villes,id',
            'ville_arrivee' => 'required|exists:villes,id|different:ville_depart',
            'date_depart' => 'required|date|after:now',
            'date_arrivee' => 'required|date|after:date_depart',
            'prix' => 'required|numeric|min:0',
            'places_disponibles' => 'required|integer|min:1|max:20'
        ]);

        Vehicule::where('id', $request->vehicule_id)
            ->where('conducteur_id', $conducteurId)
            ->firstOrFail();

        Trajet::create([
            'conducteur_id' => $conducteurId,
            'vehicule_id' => $request->vehicule_id,
            'ville_depart_id' => $request->ville_depart,
            'ville_arrivee_id' => $request->ville_arrivee,
            'date_depart' => $request->date_depart,
            'date_arrivee' => $request->date_arrivee,
            'prix' => $request->prix,
            'places_disponibles' => $request->places_disponibles,
            'statut' => 'programme'
        ]);

        return redirect('/conducteur/mes-trajets')
            ->with('success', 'Trajet créé avec succès');
    }

    // MES TRAJETS
    public function mesTrajets()
    {
        $conducteurId = session('role_id');
        
        if (!$conducteurId || session('user_role') !== 'conducteur') {
            return redirect('/login')->with('error', 'Veuillez vous connecter en tant que conducteur');
        }

        $trajets = Trajet::where('conducteur_id', $conducteurId)
            ->with(['villeDepart', 'villeArrivee', 'vehicule'])
            ->orderBy('date_depart', 'desc')
            ->get();

        return view('conducteur.mes-trajets', compact('trajets'));
    }

    // MODIFIER TRAJET
   
    public function edit($id)
    {
        $conducteurId = session('role_id');
        
        $trajet = Trajet::where('conducteur_id', $conducteurId)
            ->where('id', $id)
            ->firstOrFail();
            
        $vehicules = Vehicule::where('conducteur_id', $conducteurId)->get();
        $villes = Ville::orderBy('nom')->get();
        
        return view('conducteur.modifier-trajet', compact('trajet', 'vehicules', 'villes'));
    }

    // UPDATE TRAJET
    public function update(Request $request, $id)
    {
        $conducteurId = session('role_id');
        
        $trajet = Trajet::where('conducteur_id', $conducteurId)
            ->where('id', $id)
            ->firstOrFail();

        $request->validate([
            'ville_depart' => 'required|exists:villes,id',
            'ville_arrivee' => 'required|exists:villes,id|different:ville_depart',
            'date_depart' => 'required|date|after:now',
            'date_arrivee' => 'required|date|after:date_depart',
            'prix' => 'required|numeric|min:0',
            'places_disponibles' => 'required|integer|min:1'
        ]);

        $trajet->update([
            'ville_depart_id' => $request->ville_depart,
            'ville_arrivee_id' => $request->ville_arrivee,
            'date_depart' => $request->date_depart,
            'date_arrivee' => $request->date_arrivee,
            'prix' => $request->prix,
            'places_disponibles' => $request->places_disponibles,
        ]);

        return redirect('/conducteur/mes-trajets')
            ->with('success', 'Trajet modifié avec succès');
    }

    // SUPPRIMER TRAJET
    
    public function destroy($id)
    {
        $conducteurId = session('role_id');

        $trajet = Trajet::where('conducteur_id', $conducteurId)->findOrFail($id);

        Reservation::where('trajet_id', $id)
            ->where('statut', 'en_attente')
            ->update(['statut' => 'annulee']);

        $trajet->delete();

        return redirect('/conducteur/mes-trajets')
            ->with('success', 'Trajet supprimé avec succès');
    }

    // PASSAGERS D'UN TRAJET
    public function voirPassagers($id)
    {
        $conducteurId = session('role_id');

        $trajet = Trajet::where('conducteur_id', $conducteurId)->findOrFail($id);

        $reservations = Reservation::where('trajet_id', $id)
            ->where('statut', 'confirmee')
            ->with(['passager.utilisateur', 'paiement'])
            ->get();

        return view('conducteur.passagers', compact('trajet', 'reservations'));
    }

    // METTRE À JOUR STATUT TRAJET
    public function mettreAJourStatut(Request $request, $id)
    {
        $conducteurId = session('role_id');

        $trajet = Trajet::where('conducteur_id', $conducteurId)
            ->where('id', $id)
            ->firstOrFail();

        $request->validate([
            'statut' => 'required|in:programme,en_cours,termine,annule'
        ]);

        $trajet->statut = $request->statut;
        $trajet->save();

        return response()->json([
            'success' => true,
            'statut' => $trajet->statut
        ]);
    }

    // VEHICULES
    public function index()
    {
        $conducteurId = session('role_id');
        
        if (!$conducteurId || session('user_role') !== 'conducteur') {
            return redirect('/login')->with('error', 'Veuillez vous connecter en tant que conducteur');
        }

        $vehicules = Vehicule::where('conducteur_id', $conducteurId)->get();

        return view('conducteur.vehicules', compact('vehicules'));
    }

    // AJOUTER VEHICULE
    
    public function store(Request $request)
    {
        $conducteurId = session('role_id');
        
        if (!$conducteurId || session('user_role') !== 'conducteur') {
            return redirect('/login')->with('error', 'Veuillez vous connecter en tant que conducteur');
        }

        $request->validate([
            'immatriculation' => 'required|unique:vehicules,immatriculation',
            'marque' => 'required|string|max:50',
            'modele' => 'required|string|max:50',
            'capacite' => 'required|integer|min:1|max:9'
        ]);

        Vehicule::create([
            'immatriculation' => $request->immatriculation,
            'marque' => $request->marque,
            'modele' => $request->modele,
            'capacite' => $request->capacite,
            'statut' => 'disponible',
            'conducteur_id' => $conducteurId
        ]);

        return back()->with('success', 'Véhicule ajouté avec succès');
    }

    // SUPPRIMER VEHICULE
    public function destroyVehicule($id)
    {
        $conducteurId = session('role_id');
        
        $vehicule = Vehicule::where('conducteur_id', $conducteurId)
            ->where('id', $id)
            ->firstOrFail();
            
        $vehicule->delete();

        return response()->json([
            'success' => true,
            'message' => 'Véhicule supprimé'
        ]);
    }

    // PROFIL
    public function profil()
    {
        $conducteurId = session('role_id');
        
        $conducteur = Conducteur::with('utilisateur')->findOrFail($conducteurId);
        
        return view('conducteur.profil', compact('conducteur'));
    }

    // MODIFIER PROFIL
    public function modifierProfil(Request $request)
    {
        $conducteurId = session('role_id');
        $userId = session('user_id');
        
        $conducteur = Conducteur::findOrFail($conducteurId);
        $utilisateur = Utilisateur::findOrFail($userId);

        $request->validate([
            'nom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'numero_permis' => 'required|string|max:50',
            'password' => 'nullable|min:6|confirmed'
        ]);

        $utilisateur->update([
            'nom' => $request->nom,
            'telephone' => $request->telephone
        ]);

        $conducteur->update([
            'numero_permis' => $request->numero_permis
        ]);

        if ($request->filled('password')) {
            $utilisateur->update([
                'password' => Hash::make($request->password)
            ]);
        }

        session(['user_nom' => $utilisateur->nom]);

        return back()->with('success', 'Profil modifié avec succès');
    }
}