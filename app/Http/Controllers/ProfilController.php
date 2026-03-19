<?php

namespace App\Http\Controllers;

use App\Models\Passager;
use App\Models\Conducteur;
use App\Models\Admin;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    private function getUser()
    {
        $role = session('user_role');
        $userId = session('user_id');
        $roleId = session('role_id');

        if (!$userId || !$role) {
            return null;
        }

        $utilisateur = Utilisateur::find($userId);
        if (!$utilisateur) return null;

        $specific = null;

        switch ($role) {
            case 'passager':
                $specific = Passager::find($roleId);
                break;

            case 'conducteur':
                $specific = Conducteur::find($roleId);
                break;

            case 'admin':
                $specific = Admin::find($roleId);
                break;

            default:
                return null;
        }

        return [
            'role' => $role,
            'utilisateur' => $utilisateur,
            'specific' => $specific
        ];
    }

    public function edit()
    {
        $data = $this->getUser();

        if (!$data) {
            return redirect('/login')->with('error', 'Veuillez vous connecter');
        }

        $user = (object) array_merge(
            $data['utilisateur']->toArray(),
            $data['specific']?->toArray() ?? [],
            ['role' => $data['role']]
        );

        return view('auth.modifier-profil', compact('user'));
    }

    public function show()
    {
        $data = $this->getUser();

        if (!$data) {
            return redirect('/login')->with('error', 'Veuillez vous connecter');
        }

        return match ($data['role']) {
            'passager' => view('auth.profil-passager', [
                'utilisateur' => $data['utilisateur'],
                'specific' => $data['specific']
            ]),
            'conducteur' => view('auth.profil-conducteur', [
                'utilisateur' => $data['utilisateur'],
                'specific' => $data['specific']
            ]),
            'admin' => view('auth.profil-admin', [
                'utilisateur' => $data['utilisateur']
            ]),
            default => redirect('/login')
        };
    }

    public function update(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:20',
            'password' => 'nullable|min:6|confirmed',
            'current_password' => 'nullable|required_with:password'
        ]);

        $userId = session('user_id');

        $utilisateur = Utilisateur::find($userId);

        if (!$utilisateur) {
            return redirect('/login');
        }

        // email unique
        $exists = Utilisateur::where('email', $request->email)
            ->where('id', '!=', $userId)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Email déjà utilisé');
        }

        // password check
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $utilisateur->password)) {
                return back()->with('error', 'Mot de passe actuel incorrect');
            }
            $utilisateur->password = Hash::make($request->password);
        }

        $utilisateur->update([
            'nom' => $request->nom,
            'email' => $request->email,
            'telephone' => $request->telephone
        ]);

        session([
            'user_nom' => $utilisateur->nom,
            'user_email' => $utilisateur->email
        ]);

        return redirect('/profil')->with('success', 'Profil modifié avec succès');
    }
}