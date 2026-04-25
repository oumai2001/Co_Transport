<?php

namespace App\Http\Controllers;

use App\Models\Passager;
use App\Models\Conducteur;
use App\Models\Trajet;
use App\Models\Reservation;
use App\Models\Paiement;
use App\Models\Avis;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistiqueController extends Controller
{
    // ADMIN STATISTICS
    public function index()
    {
        $userRole = session('user_role');
        
        if ($userRole !== 'admin') {
            return redirect('/login')->with('error', 'Accès réservé à l\'administration');
        }

        $stats = [
            'total_passagers' => Passager::count(),
            'total_conducteurs' => Conducteur::count(),
            'total_trajets' => Trajet::count(),
            'trajets_programmes' => Trajet::where('statut', 'programme')->count(),
            'trajets_en_cours' => Trajet::where('statut', 'en_cours')->count(),
            'trajets_termines' => Trajet::where('statut', 'termine')->count(),
            'trajets_annules' => Trajet::where('statut', 'annule')->count(),
            'total_reservations' => Reservation::count(),
            'reservations_confirmees' => Reservation::where('statut', 'confirmee')->count(),
            'chiffre_affaires_total' => Paiement::where('statut', 'paye')->sum('montant') ?? 0,
            'note_moyenne_globale' => round(Avis::avg('note') ?? 0, 2),
        ];

        $top_conducteurs = Conducteur::with('utilisateur')
            ->withCount('trajets')
            ->orderBy('trajets_count', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($c) {
                $c->nom = $c->utilisateur->nom;
                return $c;
            });

        $chart_months = [];
        $chart_passagers = [];
        $chart_conducteurs = [];
        $chart_revenues = [];

        for ($i = 11; $i >= 0; $i--) {
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

        return view('admin.statistiques', compact(
            'stats',
            'top_conducteurs',
            'chart_months',
            'chart_passagers',
            'chart_conducteurs',
            'chart_revenues'
        ));
    }
    // CONDUCTEUR STATISTICS
    public function conducteurStats()
    {
        $conducteurId = session('role_id');
        $userRole = session('user_role');

        if (!$conducteurId || $userRole !== 'conducteur') {
            return redirect('/login')->with('error', 'Veuillez vous connecter en tant que conducteur');
        }

        $conducteur = Conducteur::with('utilisateur')->findOrFail($conducteurId);

        $stats = [
            'total_trajets' => Trajet::where('conducteur_id', $conducteurId)->count(),
            'total_passagers' => Reservation::whereHas('trajet', function ($q) use ($conducteurId) {
                $q->where('conducteur_id', $conducteurId);
            })->where('statut', 'confirmee')->count(),
            'gains_totaux' => (float) (Reservation::whereHas('trajet', function ($q) use ($conducteurId) {
                $q->where('conducteur_id', $conducteurId);
            })->where('statut', 'confirmee')->sum('prix_total') ?? 0),
            'note_moyenne' => round($conducteur->note_moyenne ?? 0, 2),
        ];

        // Trajets par mois
        $trajets_par_mois = [
            'mois' => [],
            'counts' => []
        ];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $trajets_par_mois['mois'][] = $date->format('M Y');
            $trajets_par_mois['counts'][] = Trajet::where('conducteur_id', $conducteurId)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // Gains par mois
        $gains_par_mois = [
            'mois' => [],
            'montants' => []
        ];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $gains_par_mois['mois'][] = $date->format('M Y');
            $gains_par_mois['montants'][] = (float) (Reservation::whereHas('trajet', function ($q) use ($conducteurId) {
                $q->where('conducteur_id', $conducteurId);
            })
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('statut', 'confirmee')
                ->sum('prix_total') ?? 0);
        }

        // Villes départ
        $villes_depart = Trajet::where('conducteur_id', $conducteurId)
            ->select('ville_depart_id', DB::raw('count(*) as total'))
            ->with('villeDepart')
            ->groupBy('ville_depart_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->map(fn($item) => (object)[
                'nom' => $item->villeDepart->nom ?? 'N/A',
                'total' => $item->total
            ]);

        // Villes arrivée
        $villes_arrivee = Trajet::where('conducteur_id', $conducteurId)
            ->select('ville_arrivee_id', DB::raw('count(*) as total'))
            ->with('villeArrivee')
            ->groupBy('ville_arrivee_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->map(fn($item) => (object)[
                'nom' => $item->villeArrivee->nom ?? 'N/A',
                'total' => $item->total
            ]);

        return view('conducteur.statistiques', compact(
            'conducteur',
            'stats',
            'trajets_par_mois',
            'gains_par_mois',
            'villes_depart',
            'villes_arrivee'
        ));
    }
}