<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Match20 extends Model
{
  Use HasFactory;

    protected $fillable = ['groupe2zero_id', 'sport', 'date'];

    public function groupe()
    {
        return $this->belongsTo(Groupe2Zero::class, 'groupe2zero_id');
    }

    public function equipes()
    {
        return $this->hasMany(Equipe::class);
    }

    public function statistique()
    {
        return $this->hasOne(StatistiqueMatch::class);
    }
}
