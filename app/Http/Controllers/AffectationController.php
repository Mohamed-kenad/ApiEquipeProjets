<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use Illuminate\Http\Request;

class AffectationController extends Controller
{
    public function  Affectation(Request $request, $projet_id)
    {
        $projet = Projet::findOrFail($projet_id);

        $request->validate([
            'personnes' => 'required|array',
            'personnes.*' => 'exists:personnes,id',
        ]);

        $projet->personnes()->attach($request->personnes);

        return response()->json(['message' => 'Personnes affectées avec succès']);
    }

    public function removePersonneFromProjet(Request $request, $projet_id)
    {
        $projet = Projet::findOrFail($projet_id);

        $request->validate([
            'personnes' => 'required|array',
            'personnes.*' => 'exists:personnes,id',
        ]);

        $projet->personnes()->detach($request->personnes);

        return response()->json(['message' => 'Personnes retirées du projet avec succès']);
    }
}

