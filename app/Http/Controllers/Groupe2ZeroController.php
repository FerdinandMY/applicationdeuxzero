<?php

namespace App\Http\Controllers;

use App\Models\Groupe2Zero;
use App\Notifications\Invitation2ZeroNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class Groupe2ZeroController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'nombre_joueurs' => 'required|integer|min:2',
            'sports' => 'required|array',
            'samedis_disponibles' => 'required|array',
        ]);

        $groupe = Groupe2Zero::create($validated);

        // Ex: on récupère tous les membres qu'on veut inviter
        $membres = User::whereIn('id', [/* ids des membres à inviter */])->get();

        foreach ($membres as $membre) {
            $notification = new Invitation2ZeroNotification($groupe);
            $lienWhatsApp = $notification->toWhatsAppLink();

            // Là tu peux envoyer le lien par mail, SMS ou afficher côté frontend pour que l'admin copie-colle

            // Exemple simple : loguer le lien ou le retourner en API
            Log::info("Lien WhatsApp invitation pour {$membre->name}: {$lienWhatsApp}");
        }

        return response()->json($groupe, 201);
    }

}
