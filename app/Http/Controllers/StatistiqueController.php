<?php

namespace App\Http\Controllers;

use App\Models\StatistiqueMatch;
use Illuminate\Http\Request;

class StatistiqueController extends Controller
{
    // Créer ou mettre à jour les stats d'un match
    public function storeOrUpdate(Request $request, $matchId)
    {
        $validated = $request->validate([
            'homme_du_match_id' => 'nullable|exists:users,id',
            'femme_du_match_id' => 'nullable|exists:users,id',
            'meilleur_defenseur_id' => 'nullable|exists:users,id',
            'buts_equipe_1' => 'required|integer|min:0',
            'buts_equipe_2' => 'required|integer|min:0',
            'buts' => 'nullable|array',
            'buts.*.user_id' => 'required|exists:users,id',
            'buts.*.equipe_id' => 'required|exists:equipes,id',
            'buts.*.nombre' => 'required|integer|min:1',
        ]);

        $stat = StatistiqueMatch::updateOrCreate(
            ['match_id' => $matchId],
            [
                'homme_du_match_id' => $validated['homme_du_match_id'] ?? null,
                'femme_du_match_id' => $validated['femme_du_match_id'] ?? null,
                'meilleur_defenseur_id' => $validated['meilleur_defenseur_id'] ?? null,
                'buts_equipe_1' => $validated['buts_equipe_1'],
                'buts_equipe_2' => $validated['buts_equipe_2'],
            ]
        );

        // On nettoie anciens buts
        $stat->buts()->delete();

        // On ajoute les nouveaux buts
        if (!empty($validated['buts'])) {
            foreach ($validated['buts'] as $but) {
                $stat->buts()->create([
                    'user_id' => $but['user_id'],
                    'equipe_id' => $but['equipe_id'],
                    'nombre' => $but['nombre'],
                ]);
            }
        }

        return response()->json($stat);
    }

    // Récupérer stats d'un match
    public function show($matchId)
    {
        $stat = StatistiqueMatch::with('hommeDuMatch', 'femmeDuMatch', 'meilleurDefenseur', 'buts.joueur', 'buts.equipe')
            ->where('match_id', $matchId)
            ->first();

        if (!$stat) {
            return response()->json(['message' => 'Statistiques non trouvées'], 404);
        }

        return response()->json($stat);
    }

}
