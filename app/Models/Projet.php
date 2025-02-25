<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 *     schema="Projet",
 *     title="Projet",
 *     description="Model representing a project",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="status", type="string", example="active"),
 *     @OA\Property(property="date_de_debut", type="string", format="date", example="2025-02-25"),
 *     @OA\Property(property="date_de_fin", type="string", format="date", example="2025-12-31")
 * )
 */

class Projet extends Model
{

    protected $fillable = ['status', 'date_de_debut', 'date_de_fin'];

    public function personnes()
    {
        return $this->belongsToMany(Personne::class,"personne_projet", 'personne_id', 'projet_id')->withTimestamps();
    }

   
}
