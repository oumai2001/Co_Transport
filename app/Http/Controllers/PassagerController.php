<?php

namespace App\Http\Controllers;

use App\Models\Passager;
use App\Models\Reservation;
use App\Models\Favori;
use App\Models\Avis;
use App\Models\Trajet;
use App\Models\Conducteur;
use App\Models\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PassagerController extends Controller
{
    /**
     * Dashboard passager
     */
    public function dashboard()
    {
        $passagerId = session('role_id');
        $userRole = session('user_role');

        if (!$passagerId || $userRole !== 'passager') {
            return redirect('/login')->with('error', 'Veuillez vous connecter en tant que passager');
        }

        $passager = Passager::with('utilisateur')->findOrFail($passagerId);
        
        $prochains_trajets = Reservation::where('passager_id', $passagerId)
            ->where('statut', 'confirmee')
            ->whereHas('trajet', function($q) {
                $q->where('date_depart', '>', now());
            })
            ->with(['trajet' => function($q) {
                $q->with(['villeDepart', 'villeArrivee', 'conducteur.utilisateur']);
            }])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        $historique_recent = Reservation::where('passager_id', $passagerId)
            ->whereHas('trajet', function($q) {
                $q->where('date_depart', '<', now());
            })
            ->with(['trajet' => function($q) {
                $q->with(['villeDepart', 'villeArrivee', 'conducteur.utilisateur']);
            }])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        $stats = [
            'total_reservations' => Reservation::where('passager_id', $passagerId)->count(),
            'reservations_confirmees' => Reservation::where('passager_id', $passagerId)
                ->where('statut', 'confirmee')->count(),
            'total_depense' => Reservation::where('passager_id', $passagerId)
                ->where('statut', 'confirmee')->sum('prix_total') ?? 0,
            'points_fidelite' => $passager->points_fidelite ?? 0,
        ];
        
        return view('passager.dashboard', compact(
            'passager', 
            'prochains_trajets', 
            'historique_recent', 
            'stats'
        ));
    }
    
    /**
     * Historique complet des réservations
     */
    public function historique()
    {
        $passagerId = session('role_id');
        
        if (!$passagerId) {
            return redirect('/login')->with('error', 'Veuillez vous connecter');
        }

        $reservations = Reservation::where('passager_id', $passagerId)
            ->with(['trajet' => function($q) {
                $q->with(['villeDepart', 'villeArrivee', 'conducteur.utilisateur']);
            }, 'paiement'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('passager.historique', compact('reservations'));
    }
    
    /**
     * Liste des favoris
     */
    public function favoris()
    {
        $passagerId = session('role_id');
        
        $favoris = Favori::where('passager_id', $passagerId)
            ->with(['conducteur' => function($q) {
                $q->with('utilisateur');
            }])
            ->orderBy('date_ajout', 'desc')
            ->get();
        
        return view('passager.favoris', compact('favoris'));
    }
    
    /**
     * Profil du passager
     */
    public function profil()
    {
        $passagerId = session('role_id');
        
        $passager = Passager::with('utilisateur')->findOrFail($passagerId);
        
        return view('passager.profil', compact('passager'));
    }
    
    /**
     * Modifier le profil
     */
    public function modifierProfil(Request $request)
    {
        $passagerId = session('role_id');
        $userId = session('user_id');
        
        $passager = Passager::findOrFail($passagerId);
        $utilisateur = \App\Models\Utilisateur::findOrFail($userId);
        
        $request->validate([
            'nom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email|unique:utilisateurs,email,' . $userId,
            'password' => 'nullable|min:6|confirmed'
        ]);
        
        $utilisateur->update([
            'nom' => $request->nom,
            'telephone' => $request->telephone,
            'email' => $request->email
        ]);
        
        if ($request->filled('password')) {
            $utilisateur->update([
                'password' => bcrypt($request->password)
            ]);
        }
        
        session(['user_nom' => $utilisateur->nom]);
        
        return back()->with('success', 'Profil modifié avec succès');
    }
}