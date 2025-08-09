<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatistiqueMatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'match_id', 'homme_du_match_id', 'femme_du_match_id', 'meilleur_defenseur_id', 'buts_equipe_1', 'buts_equipe_2'
    ];

    public function match()
    {
        return $this->belongsTo(Match::class);
    }

    public function hommeDuMatch()
    {
        return $this->belongsTo(User::class, 'homme_du_match_id');
    }

    public function femmeDuMatch()
    {
        return $this->belongsTo(User::class, 'femme_du_match_id');
    }

    public function meilleurDefenseur()
    {
        return $this->belongsTo(User::class, 'meilleur_defenseur_id');
    }

    public function buts()
    {
        return $this->hasMany(But::class);
    }
}
