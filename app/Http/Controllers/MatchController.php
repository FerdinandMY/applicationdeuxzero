<?php

namespace App\Http\Controllers;

use App\Models\Groupe2Zero;
use App\Models\Match20;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function index($groupeId)
    {
        $matchs = Match20::where('groupe2zero_id', $groupeId)->get();
        return response()->json($matchs);
    }

    // Création d'un match dans un groupe 2-0
    public function store(Request $request, $groupeId)
    {
        $validated = $request->validate([
            'sport' => 'required|string',
            'date' => 'required|date',
        ]);

        $groupe = Groupe2Zero::findOrFail($groupeId);

        $match = $groupe->matchs()->create([
            'sport' => $validated['sport'],
            'date' => $validated['date'],
        ]);

        return response()->json($match, 201);
    }

    // Affiche les détails d'un match (dont équipes)
    public function show($id)
    {
        $match = Match20::with('equipes.joueurs', 'equipes.capitaine')->findOrFail($id);
        return response()->json($match);
    }

}
