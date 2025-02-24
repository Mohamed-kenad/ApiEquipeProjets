<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Personne",
 *     title="Personne",
 *     description="Modèle représentant une personne",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nom", type="string", example="Dupont"),
 *     @OA\Property(property="prenom", type="string", example="Jean"),
 *     @OA\Property(property="ville", type="string", example="Paris"),
 *     @OA\Property(property="telephone", type="string", example="+33123456789")
 * )
 */
class Personne extends Model
{ 
       use HasFactory;

    protected $fillable = ["nom", "prenom", "telephone", "ville"];

    public function projets()
    {
        return $this->belongsToMany(Projet::class,"personne_projet")->withTimestamps();
    }
}
