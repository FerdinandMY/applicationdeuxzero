<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use Illuminate\Http\Request;

class EquipeController extends Controller
{
    // Liste équipes d'un match
    public function index($matchId)
    {
        $equipes = Equipe::with('joueurs', 'capitaine')->where('match_id', $matchId)->get();
        return response()->json($equipes);
    }

    // Créer une équipe (ex: "Equipe A")
    public function store(Request $request, $matchId)
    {
        $validated = $request->validate([
            'nom' => 'nullable|string',
            'capitaine_id' => 'nullable|exists:users,id',
        ]);

        $match = Match20::findOrFail($matchId);

        $equipe = $match->equipes()->create([
            'nom' => $validated['nom'] ?? null,
            'capitaine_id' => $validated['capitaine_id'] ?? null,
        ]);

        return response()->json($equipe, 201);
    }

    // Ajouter un joueur à une équipe
    public function addJoueur(Request $request, $equipeId)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $equipe = Equipe::findOrFail($equipeId);

        $equipe->joueurs()->syncWithoutDetaching($validated['user_id']);

        return response()->json(['message' => 'Joueur ajouté']);
    }

    // Supprimer un joueur d'une équipe
    public function removeJoueur(Request $request, $equipeId)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $equipe = Equipe::findOrFail($equipeId);

        $equipe->joueurs()->detach($validated['user_id']);

        return response()->json(['message' => 'Joueur retiré']);
    }

}
