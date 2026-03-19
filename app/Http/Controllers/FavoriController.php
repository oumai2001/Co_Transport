<?php

namespace App\Http\Controllers;

use App\Models\Favori;
use App\Models\Conducteur;
use Illuminate\Http\Request;

class FavoriController extends Controller
{
    /**
     * Afficher la liste des favoris du passager
     */
    public function index()
    {
        $passagerId = session('role_id');
        $userRole = session('user_role');

        if (!$passagerId || $userRole !== 'passager') {
            return redirect('/login')->with('error', 'Veuillez vous connecter en tant que passager');
        }

        $favoris = Favori::where('passager_id', $passagerId)
            ->with(['conducteur' => function($q) {
                $q->with('utilisateur');
            }])
            ->orderBy('date_ajout', 'desc')
            ->get();

        return view('passager.favoris', compact('favoris'));
    }

    /**
     * Ajouter un conducteur aux favoris
     */
 public function ajouter($id)
{
    $passagerId = session('role_id');
    $userRole = session('user_role');

    if (!$passagerId || $userRole !== 'passager') {
        return response()->json(['success' => false, 'message' => 'Non authentifié'], 401);
    }

    $conducteur = Conducteur::find($id);
    if (!$conducteur) {
        return response()->json(['success' => false, 'message' => 'Conducteur introuvable'], 404);
    }

    $exists = Favori::where('passager_id', $passagerId)
        ->where('conducteur_id', $id)
        ->exists();

    if ($exists) {
        return response()->json(['success' => false, 'message' => 'Déjà dans vos favoris']);
    }

    $favori = Favori::create([
        'passager_id' => $passagerId,
        'conducteur_id' => $id,
        'date_ajout' => now()
    ]);

    return response()->json(['success' => true, 'message' => 'Ajouté aux favoris']);
}

public function supprimerParConducteur($conducteurId)
{
    $passagerId = session('role_id');
    $userRole = session('user_role');

    if (!$passagerId || $userRole !== 'passager') {
        return response()->json(['success' => false, 'message' => 'Non authentifié'], 401);
    }

    $deleted = Favori::where('passager_id', $passagerId)
        ->where('conducteur_id', $conducteurId)
        ->delete();

    if ($deleted) {
        return response()->json(['success' => true, 'message' => 'Retiré des favoris']);
    }

    return response()->json(['success' => false, 'message' => 'Favori non trouvé'], 404);
}


    /**
     * Supprimer un favori par son ID
     */
       public function supprimer($id)
{
    $passagerId = session('role_id');
    $userRole = session('user_role');

    if (!$passagerId || $userRole !== 'passager') {
        return response()->json([
            'success' => false,
            'message' => 'Non authentifié'
        ], 401);
    }

    $favori = Favori::where('id', $id)
        ->where('passager_id', $passagerId)
        ->first();

    if (!$favori) {
        return response()->json([
            'success' => false,
            'message' => 'Favori introuvable'
        ], 404);
    }

    $favori->delete();

    return response()->json([
        'success' => true,
        'message' => 'Favori supprimé'
    ]);
}
    }

