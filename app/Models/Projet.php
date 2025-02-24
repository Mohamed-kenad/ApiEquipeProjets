<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{

    protected $fillable = ['status', 'date_de_debut', 'date_de_fin'];

    public function personnes()
    {
        return $this->belongsToMany(Personne::class,"personne_projet", 'personne_id', 'projet_id')->withTimestamps();
    }

   
}
