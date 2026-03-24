<?php

namespace App\Http\Controllers;

use App\Models\Trajet;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConducteurController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:conducteur');
    }
    
    // Dashboard du conducteur
    public function dashboard()
    {
        $user = Auth::user();
        $conducteur = $user->conducteur;
        
        $trajets = $conducteur->trajets()
                             ->orderBy('date_depart', 'asc')
                             ->get();
        
        $vehicules = $conducteur->vehicules()->get();
        
        $trajetsEnCours = $trajets->where('statut', 'programmé')->count();
        
        return view('conducteur.dashboard', compact('user', 'trajets', 'vehicules', 'trajetsEnCours'));
    }
    
    // Voir les passagers d'un trajet
    public function passagers(Trajet $trajet)
    {
        $this->authorize('view', $trajet);
        
        $reservations = $trajet->reservations()
                              ->with('passager.utilisateur')
                              ->where('statut', 'confirmée')
                              ->get();
        
        return view('conducteur.passagers', compact('trajet', 'reservations'));
    }
}