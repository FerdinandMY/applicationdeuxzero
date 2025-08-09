<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{

    use HasFactory;

    protected $fillable = ['match_id', 'nom', 'capitaine_id'];

    public function match()
    {
        return $this->belongsTo(Match20::class);
    }

    public function capitaine()
    {
        return $this->belongsTo(User::class, 'capitaine_id');
    }

    public function joueurs()
    {
        return $this->belongsToMany(User::class, 'joueur_equipe')->withTimestamps();
    }
}
