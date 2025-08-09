<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class Invitation2ZeroNotification extends Notification
{
    use Queueable;

    protected $groupe;

    public function __construct($groupe)
    {
        $this->groupe = $groupe;
    }

    public function via($notifiable)
    {
        // On ne fait que l'envoi manuel, donc pas de canal par défaut
        return [];
    }

    // Génère le lien WhatsApp à partager
    public function toWhatsAppLink()
    {
        // URL d'inscription avec paramètre groupe pour que l'utilisateur rejoigne ce groupe après inscription
        $urlInscription = url("/inscription?groupe_id={$this->groupe->id}");

        $texte = "Salut ! Rejoins notre groupe 2-0 '{$this->groupe->nom}' pour jouer tous les samedis. Inscris-toi ici : {$urlInscription}";
        $texteEncode = urlencode($texte);

        return "https://wa.me/?text={$texteEncode}";
    }

}
