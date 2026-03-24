<?php

namespace App\Http\Controllers;

use App\Models\Trajet;
use App\Models\Favori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:passager');
    }
    
    // Ajouter un favori
    public function store(Trajet $trajet)
    {
        $passager = Auth::user()->passager;
        
        // Vérifier si déjà favori
        $existant = Favori::where('passager_id', $passager->id)
                         ->where('trajet_id', $trajet->id)
                         ->first();
        
        if ($existant) {
            return back()->with('info', 'Déjà dans vos favoris');
        }
        
        Favori::create([
            'passager_id' => $passager->id,
            'trajet_id' => $trajet->id
        ]);
        
        return back()->with('success', 'Ajouté aux favoris');
    }
    
    // Supprimer un favori
    public function destroy(Favori $favori)
    {
        $this->authorize('delete', $favori);
        
        $favori->delete();
        
        return back()->with('success', 'Retiré des favoris');
    }
    
    // Liste des favoris
    public function index()
    {
        $passager = Auth::user()->passager;
        
        $favoris = $passager->favoris()
                           ->with('trajet.villeDepart', 'trajet.villeArrivee')
                           ->orderBy('created_at', 'desc')
                           ->get();
        
        return view('passager.favoris', compact('favoris'));
    }
}