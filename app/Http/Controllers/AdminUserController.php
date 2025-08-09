<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminUserController extends Controller
{
    // Affiche la liste des users en attente
    public function pending()
    {
        $users = User::where('statut', 'pending')->get();
        return view('admin.users.pending', compact('users'));
    }

    // Valide un utilisateur (change statut en active)
    public function valider(User $user)
    {
        $user->statut = 'active';
        $user->save();

        return redirect()->route('admin.users.pending')->with('success', 'Utilisateur validé avec succès.');
    }

}
