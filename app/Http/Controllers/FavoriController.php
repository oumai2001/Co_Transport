<?php

namespace App\Http\Controllers;

use App\Models\Trajet;
use App\Models\Favori;
use Illuminate\Http\Request;

class FavoriController extends Controller
{
    // Ajouter un favori
    public function store($trajet_id, Request $request)
    {
        $user = $request->user();
        
        if ($user->type != 'passager') {
            return response()->json(['message' => 'Seuls les passagers peuvent ajouter des favoris'], 403);
        }

        $trajet = Trajet::findOrFail($trajet_id);
        $passager = $user->passager;

        // Vérifier si déjà favori
        $existant = Favori::where('passager_id', $passager->id)
                         ->where('trajet_id', $trajet_id)
                         ->first();

        if ($existant) {
            return response()->json(['message' => 'Déjà dans vos favoris'], 400);
        }

        $favori = Favori::create([
            'passager_id' => $passager->id,
            'trajet_id' => $trajet_id
        ]);

        return response()->json([
            'message' => 'Favori ajouté',
            'favori' => $favori
        ], 201);
    }

    // Supprimer un favori
    public function destroy($id, Request $request)
    {
        $user = $request->user();
        
        if ($user->type != 'passager') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $favori = Favori::findOrFail($id);
        
        if ($favori->passager_id != $user->passager->id) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $favori->delete();

        return response()->json(['message' => 'Favori supprimé']);
    }

    // Mes favoris
    public function index(Request $request)
    {
        $user = $request->user();
        
        if ($user->type != 'passager') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $favoris = $user->passager->favoris()
                                  ->with('trajet.villeDepart', 'trajet.villeArrivee')
                                  ->orderBy('created_at', 'desc')
                                  ->get();

        return response()->json($favoris);
    }
}