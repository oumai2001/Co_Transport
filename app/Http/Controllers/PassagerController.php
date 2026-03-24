<?php

namespace App\Http\Controllers;

use App\Models\Trajet;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PassagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:passager');
    }
    
    // Dashboard du passager
    public function dashboard()
    {
        $user = Auth::user();
        $passager = $user->passager;
        
        $trajets = Trajet::where('date_depart', '>', now())
                        ->where('places_disponibles', '>', 0)
                        ->orderBy('date_depart')
                        ->limit(10)
                        ->get();
        
        $reservations = $passager->reservations()
                                ->with('trajet')
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();
        
        return view('passager.dashboard', compact('user', 'trajets', 'reservations'));
    }
    
    // Historique des réservations
    public function historique()
    {
        $user = Auth::user();
        $passager = $user->passager;
        
        $reservations = $passager->reservations()
                                ->with('trajet')
                                ->orderBy('created_at', 'desc')
                                ->paginate(10);
        
        return view('passager.historique', compact('reservations'));
    }
}