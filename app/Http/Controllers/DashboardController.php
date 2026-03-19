<?php

namespace App\Http\Controllers;

use App\Models\Passager;
use App\Models\Conducteur;
use App\Models\Trajet;
use App\Models\Reservation;
use App\Models\Avis;

class DashboardController extends Controller
{
    // Dashboard passager
    public function passagerDashboard()
    {
        $userRole = session('user_role');
        $passagerId = session('role_id');

        // Vérifier que l'utilisateur est bien un passager
        if ($userRole !== 'passager') {
            return redirect('/login')->with('error', 'Accès non autorisé');
        }

        // Récupérer le passager avec son utilisateur
        $passager = Passager::with('utilisateur')->findOrFail($passagerId);

        //  STATS
        $stats = [
            'total_reservations' => Reservation::where('passager_id', $passagerId)->count(),
            'reservations_confirmees' => Reservation::where('passager_id', $passagerId)
                ->where('statut', 'confirmee')->count(),
            'total_depense' => Reservation::where('passager_id', $passagerId)
                ->where('statut', 'confirmee')->sum('prix_total') ?? 0,
        ];

        // Prochains trajets (réservations confirmées à venir)
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

        //  Historique récent
        $historique_recent = Reservation::where('passager_id', $passagerId)
            ->with(['trajet' => function($q) {
                $q->with(['villeDepart', 'villeArrivee', 'conducteur.utilisateur']);
            }])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('passager.dashboard', compact(
            'passager',
            'stats',
            'prochains_trajets',
            'historique_recent'
        ));
    }

    // Dashboard conducteur
    public function conducteurDashboard()
    {
        $userRole = session('user_role');
        $conducteurId = session('role_id');

        // Vérifier que l'utilisateur est bien un conducteur
        if ($userRole !== 'conducteur') {
            return redirect('/login')->with('error', 'Accès non autorisé');
        }

        // Récupérer le conducteur avec son utilisateur
        $conducteur = Conducteur::with('utilisateur')->findOrFail($conducteurId);

        //  STATS
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

        // Prochains trajets à venir
        $prochains_trajets = Trajet::where('conducteur_id', $conducteurId)
            ->where('date_depart', '>', now())
            ->where('statut', 'programme')
            ->orderBy('date_depart', 'asc')
            ->with(['villeDepart', 'villeArrivee', 'vehicule'])
            ->limit(5)
            ->get();

        //  Dernières réservations reçues
        $dernieres_reservations = Reservation::whereHas('trajet', function ($q) use ($conducteurId) {
                $q->where('conducteur_id', $conducteurId);
            })
            ->where('statut', 'confirmee')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->with(['passager.utilisateur', 'trajet' => function($q) {
                $q->with(['villeDepart', 'villeArrivee']);
            }])
            ->get();

        return view('conducteur.dashboard', compact(
            'conducteur',
            'stats',
            'prochains_trajets',
            'dernieres_reservations'
        ));
    }

    // Redirection générale basée sur le rôle
    public function redirectBasedOnRole()
    {
        $userRole = session('user_role');
        
        return match ($userRole) {
            'admin' => redirect('/admin/dashboard'),
            'conducteur' => redirect('/conducteur/dashboard'),
            'passager' => redirect('/passager/dashboard'),
            default => redirect('/login')->with('error', 'Rôle non reconnu'),
        };
    }
}