<?php

namespace App\Http\Controllers;

use App\Models\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VilleController extends Controller
{
    //Liste des villes 
    public function index()
    {
        $userRole = session('user_role');
        
        if ($userRole !== 'admin') {
            return redirect('/login')->with('error', 'Accès réservé à l\'administration');
        }

        $villes = Ville::orderBy('nom')->paginate(20);

        return view('admin.villes', compact('villes'));
    }

    // Recherche de villes
    public function rechercheJSON(Request $request)
    {
        $q = $request->get('q');
        $limit = $request->get('limit', 10);
        
        if (strlen($q) < 2) {
            return response()->json([]);
        }
        
        $villes = Ville::where('nom', 'like', "%{$q}%")
            ->orWhere('code_postal', 'like', "%{$q}%")
            ->orderBy('nom')
            ->limit($limit)
            ->get()
            ->map(function($ville) {
                return [
                    'id' => $ville->id,
                    'nom' => $ville->nom,
                    'code_postal' => $ville->code_postal,
                    'pays' => $ville->pays,
                    'label' => "{$ville->nom} ({$ville->code_postal}) - {$ville->pays}"
                ];
            });
        
        return response()->json($villes);
    }

    //Ajouter une ville 
    public function store(Request $request)
    {
        $userRole = session('user_role');
        
        if ($userRole !== 'admin') {
            return redirect('/login')->with('error', 'Accès réservé à l\'administration');
        }

        $request->validate([
            'nom' => 'required|string|max:100|unique:villes,nom',
            'code_postal' => 'required|string|max:10',
            'pays' => 'required|string|max:50'
        ]);

        DB::beginTransaction();

        try {
            Ville::create([
                'nom' => ucfirst($request->nom),
                'code_postal' => $request->code_postal,
                'pays' => $request->pays
            ]);

            DB::commit();

            return back()->with('success', 'Ville ajoutée avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de l\'ajout');
        }
    }

    //Modifier une ville 
    public function update(Request $request, $id)
    {
        $userRole = session('user_role');
        
        if ($userRole !== 'admin') {
            return redirect('/login')->with('error', 'Accès réservé à l\'administration');
        }

        $ville = Ville::findOrFail($id);

        $request->validate([
            'nom' => 'required|string|max:100|unique:villes,nom,' . $id,
            'code_postal' => 'required|string|max:10',
            'pays' => 'required|string|max:50'
        ]);

        DB::beginTransaction();

        try {
            $ville->update([
                'nom' => ucfirst($request->nom),
                'code_postal' => $request->code_postal,
                'pays' => $request->pays
            ]);

            DB::commit();

            return back()->with('success', 'Ville modifiée avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la modification');
        }
    }

    // Supprimer une ville
    public function destroy($id)
    {
        $userRole = session('user_role');
        
        if ($userRole !== 'admin') {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $ville = Ville::findOrFail($id);
        
        // Vérifier si la ville est utilisée dans des trajets
        $trajetsDepart = $ville->trajetsDepart()->count();
        $trajetsArrivee = $ville->trajetsArrivee()->count();
        
        if ($trajetsDepart > 0 || $trajetsArrivee > 0) {
            return response()->json([
                'error' => "Cette ville ne peut pas être supprimée car elle est utilisée dans des trajets"
            ], 400);
        }

        DB::beginTransaction();

        try {
            $ville->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Ville supprimée avec succès'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erreur lors de la suppression'], 500);
        }
    }

    // Obtenir toutes les villes pour formulaire 
     
    public function getAll()
    {
        $villes = Ville::orderBy('nom')->get(['id', 'nom', 'code_postal', 'pays']);
        
        return response()->json($villes);
    }
}