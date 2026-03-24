<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use App\Models\Conducteur;
use App\Models\Trajet;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }
    
    // Dashboard admin
    public function dashboard()
    {
        $stats = [
            'utilisateurs' => Utilisateur::count(),
            'conducteurs' => Conducteur::count(),
            'trajets' => Trajet::count(),
            'reservations' => Reservation::count(),
            'trajets_aujourdhui' => Trajet::whereDate('date_depart', today())->count(),
        ];
        
        $derniersTrajets = Trajet::with('conducteur.utilisateur')
                                 ->orderBy('created_at', 'desc')
                                 ->limit(5)
                                 ->get();
        
        return view('admin.dashboard', compact('stats', 'derniersTrajets'));
    }
    
    // Valider un conducteur
    public function validerConducteur(Conducteur $conducteur)
    {
        $conducteur->verification = true;
        $conducteur->save();
        
        return back()->with('success', 'Conducteur validé');
    }
    
    // Suspendre un utilisateur
    public function suspendre(Utilisateur $user)
    {
        $user->statut_compte = $user->statut_compte === 'actif' ? 'suspendu' : 'actif';
        $user->save();
        
        return back()->with('success', 'Statut utilisateur modifié');
    }
    
    // Liste des utilisateurs
    public function utilisateurs()
    {
        $utilisateurs = Utilisateur::paginate(20);
        return view('admin.utilisateurs', compact('utilisateurs'));
    }
}