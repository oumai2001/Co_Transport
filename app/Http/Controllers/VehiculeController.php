<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehiculeController extends Controller
{
    //Liste des véhicules du conducteur
    public function index()
    {
        $conducteurId = session('role_id');
        $userRole = session('user_role');

        if (!$conducteurId || $userRole !== 'conducteur') {
            return redirect('/login')->with('error', 'Veuillez vous connecter en tant que conducteur');
        }

        $vehicules = Vehicule::where('conducteur_id', $conducteurId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('conducteur.vehicules', compact('vehicules'));
    }

    //Ajouter un véhicule
    public function store(Request $request)
    {
        $conducteurId = session('role_id');
        $userRole = session('user_role');

        if (!$conducteurId || $userRole !== 'conducteur') {
            return redirect('/login')->with('error', 'Veuillez vous connecter en tant que conducteur');
        }

        $request->validate([
            'immatriculation' => 'required|string|max:20|unique:vehicules,immatriculation',
            'marque' => 'required|string|max:50',
            'modele' => 'required|string|max:50',
            'capacite' => 'required|integer|min:1|max:9',
        ]);

        DB::beginTransaction();

        try {
            $vehicule = Vehicule::create([
                'immatriculation' => strtoupper($request->immatriculation),
                'marque' => $request->marque,
                'modele' => $request->modele,
                'capacite' => $request->capacite,
                'statut' => 'disponible',
                'conducteur_id' => $conducteurId,
            ]);

            DB::commit();

            return back()->with('success', 'Véhicule ajouté avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de l\'ajout');
        }
    }

    //Supprimer un véhicule
    public function destroy($id)
    {
        $conducteurId = session('role_id');
        $userRole = session('user_role');

        if (!$conducteurId || $userRole !== 'conducteur') {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $vehicule = Vehicule::where('conducteur_id', $conducteurId)
            ->findOrFail($id);

        $vehicule->delete();

        return response()->json([
            'success' => true,
            'message' => 'Véhicule supprimé avec succès'
        ]);
    }

    // Mettre à jour le statut uniquement
    public function updateStatut(Request $request, $id)
    {
        $conducteurId = session('role_id');
        $userRole = session('user_role');

        if (!$conducteurId || $userRole !== 'conducteur') {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $vehicule = Vehicule::where('conducteur_id', $conducteurId)
            ->findOrFail($id);

        $request->validate([
            'statut' => 'required|in:disponible,maintenance,en_trajet'
        ]);

        $vehicule->statut = $request->statut;
        $vehicule->save();

        return response()->json([
            'success' => true,
            'statut' => $vehicule->statut
        ]);
    }
}