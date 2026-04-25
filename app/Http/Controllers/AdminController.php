<?php

namespace App\Http\Controllers;

use App\Models\Passager;
use App\Models\Conducteur;
use App\Models\Trajet;
use App\Models\Vehicule;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\Paiement;
use App\Models\Avis;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Dashboard admin
    public function dashboard()
    {
        $stats['total_passagers'] = Passager::count();
        $stats['total_conducteurs'] = Conducteur::count();
        $stats['total_utilisateurs'] = Utilisateur::count();
        $stats['total_trajets'] = Trajet::count();
        $stats['trajets_programmes'] = Trajet::where('statut', 'programme')->count();
        $stats['trajets_en_cours'] = Trajet::where('statut', 'en_cours')->count();
        $stats['trajets_termines'] = Trajet::where('statut', 'termine')->count();
        $stats['trajets_annules'] = Trajet::where('statut', 'annule')->count();
        $stats['total_reservations'] = Reservation::count();
        $stats['reservations_confirmees'] = Reservation::where('statut', 'confirmee')->count();
        $stats['chiffre_affaires_total'] = Paiement::where('statut', 'paye')->sum('montant') ?? 0;
        $stats['panier_moyen'] = Paiement::where('statut', 'paye')->avg('montant') ?? 0;
        $stats['note_moyenne_globale'] = round(Avis::avg('note') ?? 0, 2);
        $stats['nouveaux_passagers_mois'] = Passager::whereMonth('created_at', now()->month)->count();
        $stats['nouveaux_conducteurs_mois'] = Conducteur::whereMonth('created_at', now()->month)->count();
        $stats['trajets_mois'] = Trajet::whereMonth('created_at', now()->month)->count();
        $stats['evolution_ca'] = 0;
        
        // Top conducteurs
        $top_conducteurs = Conducteur::with('utilisateur')
            ->withCount('trajets')
            ->orderBy('trajets_count', 'desc')
            ->take(5)
            ->get()
            ->map(function($c) {
                $c->nom = $c->utilisateur->nom;
                $c->email = $c->utilisateur->email;
                return $c;
            });
        
        // Graphiques
        $chart_months = [];
        $chart_passagers = [];
        $chart_conducteurs = [];
        $chart_revenues = [];
        
        for($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $chart_months[] = $date->format('M Y');
            $chart_passagers[] = Passager::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)->count();
            $chart_conducteurs[] = Conducteur::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)->count();
            $chart_revenues[] = (float) (Paiement::where('statut', 'paye')
                ->whereYear('date_paiement', $date->year)
                ->whereMonth('date_paiement', $date->month)->sum('montant') ?? 0);
        }
        
        // Dernières activités
        $dernieres_activites = collect();
        
        $reservations = Reservation::with(['passager.utilisateur', 'trajet'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function($r) {
                return (object)[
                    'type' => 'reservation',
                    'description' => "Réservation #{$r->id} - " . ($r->passager->utilisateur->nom ?? 'Inconnu') . " a réservé un trajet",
                    'created_at' => $r->created_at
                ];
            });
        
        $trajetsList = Trajet::with(['conducteur.utilisateur'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function($t) {
                return (object)[
                    'type' => 'trajet',
                    'description' => "Trajet #{$t->id} - " . ($t->conducteur->utilisateur->nom ?? 'Inconnu') . " a proposé un nouveau trajet",
                    'created_at' => $t->created_at
                ];
            });
        
        $dernieres_activites = $reservations->concat($trajetsList)->sortByDesc('created_at')->take(10);
        
        return view('admin.dashboard', compact('stats', 'top_conducteurs', 
            'chart_months', 'chart_passagers', 'chart_conducteurs', 'chart_revenues', 'dernieres_activites'));
    }
    
    // Gestion des passagers
    public function gererPassagers()
    {
        $passagers = Passager::with('utilisateur')->get();
        return view('admin.passagers', compact('passagers'));
    }
    
    // Gestion des conducteurs
    public function gererConducteurs()
    {
        $conducteurs = Conducteur::with('utilisateur')->withCount('trajets')->get();
        return view('admin.conducteurs', compact('conducteurs'));
    }
    
    // AJOUTER PASSAGER
    public function ajouterPassager(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:utilisateurs,email',
            'telephone' => 'required|string|max:20',
            'password' => 'required|min:6'
        ]);
        
        DB::beginTransaction();
        
        try {
            $utilisateur = Utilisateur::create([
                'nom' => $request->nom,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'telephone' => $request->telephone
            ]);
            
            $passager = Passager::create([
                'utilisateur_id' => $utilisateur->id,
                'points_fidelite' => 0,
                'est_bloque' => false
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => ' Passager ajouté avec succès',
                'passager' => [
                    'id' => $passager->id,
                    'nom' => $utilisateur->nom,
                    'email' => $utilisateur->email,
                    'telephone' => $utilisateur->telephone
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error' => 'Erreur lors de l\'ajout'], 500);
        }
    }
    
    // AJOUTER CONDUCTEUR 
    public function ajouterConducteur(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:utilisateurs,email',
            'telephone' => 'required|string|max:20',
            'numero_permis' => 'required|string|max:50',
            'password' => 'required|min:6'
        ]);
        
        DB::beginTransaction();
        
        try {
            $utilisateur = Utilisateur::create([
                'nom' => $request->nom,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'telephone' => $request->telephone
            ]);
            
            $conducteur = Conducteur::create([
                'utilisateur_id' => $utilisateur->id,
                'numero_permis' => $request->numero_permis,
                'note_moyenne' => 0,
                'est_bloque' => false
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => ' Conducteur ajouté avec succès',
                'conducteur' => [
                    'id' => $conducteur->id,
                    'nom' => $utilisateur->nom,
                    'email' => $utilisateur->email,
                    'telephone' => $utilisateur->telephone
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error' => 'Erreur lors de l\'ajout'], 500);
        }
    }
    
    // BLOQUER/DÉBLOQUER PASSAGER
    public function bloquerPassager($id)
    {
        $passager = Passager::findOrFail($id);
        $passager->est_bloque = !$passager->est_bloque;
        $passager->save();
        
        return response()->json([
            'success' => true,
            'message' => $passager->est_bloque ? ' Passager bloqué' : ' Passager débloqué'
        ]);
    }
    
    // BLOQUER/DÉBLOQUER CONDUCTEUR 
    public function bloquerConducteur($id)
    {
        $conducteur = Conducteur::findOrFail($id);
        $conducteur->est_bloque = !$conducteur->est_bloque;
        $conducteur->save();
        
        return response()->json([
            'success' => true,
            'message' => $conducteur->est_bloque ? ' Conducteur bloqué' : ' Conducteur débloqué'
        ]);
    }
    
    // SUPPRIMER PASSAGER 
    public function supprimerPassager($id)
    {
        $passager = Passager::findOrFail($id);
        if ($passager->utilisateur) {
            $passager->utilisateur->delete();
        } else {
            $passager->delete();
        }
        
        return response()->json(['success' => true, 'message' => ' Passager supprimé']);
    }
    
    // SUPPRIMER CONDUCTEUR
    public function supprimerConducteur($id)
    {
        $conducteur = Conducteur::findOrFail($id);
        if ($conducteur->utilisateur) {
            $conducteur->utilisateur->delete();
        } else {
            $conducteur->delete();
        }
        
        return response()->json(['success' => true, 'message' => ' Conducteur supprimé']);
    }
    
    // Gestion des trajets
    public function gererTrajets()
    {
        $trajets = Trajet::with(['conducteur.utilisateur', 'villeDepart', 'villeArrivee'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.trajets', compact('trajets'));
    }
    
    public function validerTrajet($id)
    {
        $trajet = Trajet::findOrFail($id);
        $trajet->statut = 'programme';
        $trajet->save();
        return response()->json(['success' => true, 'message' => ' Trajet validé']);
    }
    
    public function supprimerTrajet($id)
    {
        Trajet::destroy($id);
        return response()->json(['success' => true, 'message' => ' Trajet supprimé']);
    }
    
    // Gestion des véhicules
    public function gererVehicules()
    {
        $vehicules = Vehicule::with('conducteur.utilisateur')->get();
        return view('admin.vehicules', compact('vehicules'));
    }
    
    public function supprimerVehicule($id)
    {
        try {
            $vehicule = Vehicule::findOrFail($id);
            $vehicule->delete();
            return response()->json(['success' => true, 'message' => ' Véhicule supprimé']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Erreur'], 500);
        }
    }
    
    // Gestion des réservations
    public function gererReservations()
    {
        $reservations = Reservation::with([
            'passager.utilisateur', 
            'trajet.conducteur.utilisateur',
            'trajet.villeDepart', 
            'trajet.villeArrivee'
        ])->orderBy('created_at', 'desc')->get();
        
        return view('admin.reservations', compact('reservations'));
    }
    
    public function annulerReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->statut = 'annulee';
        $reservation->save();
        
        $trajet = $reservation->trajet;
        if ($trajet) {
            $trajet->places_disponibles += $reservation->nombre_places;
            $trajet->save();
        }
        
        return response()->json(['success' => true, 'message' => ' Réservation annulée']);
    }
    
    // Statistiques
    public function statistiques()
    {
        $stats = [
            'total_passagers' => Passager::count(),
            'total_conducteurs' => Conducteur::count(),
            'total_utilisateurs' => Utilisateur::count(),
            'total_trajets' => Trajet::count(),
            'trajets_programmes' => Trajet::where('statut', 'programme')->count(),
            'trajets_en_cours' => Trajet::where('statut', 'en_cours')->count(),
            'trajets_termines' => Trajet::where('statut', 'termine')->count(),
            'trajets_annules' => Trajet::where('statut', 'annule')->count(),
            'total_reservations' => Reservation::count(),
            'reservations_confirmees' => Reservation::where('statut', 'confirmee')->count(),
            'chiffre_affaires_total' => Paiement::where('statut', 'paye')->sum('montant') ?? 0,
            'note_moyenne_globale' => round(Avis::avg('note') ?? 0, 2),
            'total_avis' => Avis::count(),
            'panier_moyen' => Paiement::where('statut', 'paye')->avg('montant') ?? 0,
            'taux_annulation' => Reservation::count() > 0 ? round((Reservation::where('statut', 'annulee')->count() / Reservation::count()) * 100, 2) : 0,
        ];
        
        $top_conducteurs = Conducteur::with('utilisateur')
            ->withCount('trajets')
            ->orderBy('trajets_count', 'desc')
            ->take(5)
            ->get()
            ->map(function($c) {
                $c->nom = $c->utilisateur->nom;
                return $c;
            });
        
        $chart_months = [];
        $chart_passagers = [];
        $chart_conducteurs = [];
        $chart_revenues = [];
        
        for($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $chart_months[] = $date->format('M Y');
            $chart_passagers[] = Passager::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)->count();
            $chart_conducteurs[] = Conducteur::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)->count();
            $chart_revenues[] = (float) (Paiement::where('statut', 'paye')
                ->whereYear('date_paiement', $date->year)
                ->whereMonth('date_paiement', $date->month)->sum('montant') ?? 0);
        }
        
        return view('admin.statistiques', compact('stats', 'top_conducteurs', 
            'chart_months', 'chart_passagers', 'chart_conducteurs', 'chart_revenues'));
    }
}