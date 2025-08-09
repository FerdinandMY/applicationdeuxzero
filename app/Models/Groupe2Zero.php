<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groupe2Zero extends Model
{
    public function membres()
    {
        return $this->belongsToMany(User::class, 'groupe2zero_user');
    }
}
