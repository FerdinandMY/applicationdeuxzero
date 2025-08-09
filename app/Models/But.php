<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class But extends Model
{
    use HasFactory;

    protected $fillable = ['statistique_match_id', 'user_id', 'equipe_id', 'nombre'];

    public function statistique()
    {
        return $this->belongsTo(StatistiqueMatch::class, 'statistique_match_id');
    }

    public function joueur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function equipe()
    {
        return $this->belongsTo(Equipe::class);
    }
}
