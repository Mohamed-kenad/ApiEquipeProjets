<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjetResource;
use App\Models\Projet;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Projets",
 *     description="Operations related to projects"
 * )
 */
class ProjetController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/projets",
     *     summary="Récupérer tous les projets",
     *     tags={"Projets"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des projets",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Projet"))
     *     )
     * )
     */
    public function index()
    {
        $projets = Projet::paginate(10);
        return ProjetResource::collection($projets);
    }

    /**
     * @OA\Post(
     *     path="/api/projets",
     *     summary="Créer un nouveau projet",
     *     tags={"Projets"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Projet")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Projet créé avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Projet")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|string|max:255',
            'date_de_debut' => 'required|date',
            'date_de_fin' => 'nullable|date',
        ]);

        $projet = Projet::create($request->all());
        return new ProjetResource($projet);
    }

    /**
     * @OA\Get(
     *     path="/api/projets/{id}",
     *     summary="Récupérer un projet par ID",
     *     tags={"Projets"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du projet",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Détails du projet",
     *         @OA\JsonContent(ref="#/components/schemas/Projet")
     *     ),
     *     @OA\Response(response=404, description="Projet non trouvé")
     * )
     */
    public function show($id)
    {
        $projet = Projet::findOrFail($id);
        return new ProjetResource($projet);
    }

    /**
     * @OA\Put(
     *     path="/api/projets/{id}",
     *     summary="Mettre à jour un projet",
     *     tags={"Projets"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du projet",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Projet")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Projet mis à jour avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Projet")
     *     ),
     *     @OA\Response(response=404, description="Projet non trouvé")
     * )
     */
    public function update(Request $request, $id)
    {
        $projet = Projet::find($id);
        if (!$projet) {
            return response()->json(['error' => 'Ressource introuvable'], 404);
        }

        $request->validate([
            'status' => 'nullable|string|max:255',
            'date_de_debut' => 'required|date',
            'date_de_fin' => 'required|date',
        ]);
        
        $projet->update($request->all());
        return new ProjetResource($projet);
    }

    /**
     * @OA\Delete(
     *     path="/api/projets/{id}",
     *     summary="Supprimer un projet",
     *     tags={"Projets"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du projet",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Projet supprimé avec succès"
     *     ),
     *     @OA\Response(response=404, description="Projet non trouvé")
     * )
     */
    public function destroy($id)
    {
        $projet = Projet::find($id);
        if (!$projet) {
            return response()->json(['error' => 'Ressource introuvable'], 404);
        }

        $projet->delete();
        return response()->json(["message" => "Projet supprimé avec succès"], 200);
    }
    public function getPersonnes($id)
    {
        $projet = Projet::with('personnes')->findOrFail($id);
        return response()->json($projet->personnes);
    }

    
    public function projetsTermines()
    {
        $projets = Projet::where('date_de_fin', '>', now())->where('statut', 'Termine')->get();
        return response()->json($projets);
    }

        public function projetsEnRetard()
    {
        $projets = Projet::where('date_de_fin', '<', now())->whereNull('statut')->get();
        return response()->json($projets);
    }

        public function projetsTerminesEnRetard()
    {
        $projets = Projet::where('date_de_fin', '<', now())->where('statut', 'Termine')->get();
        return response()->json($projets);
    }

        public function projetRetardMax()
    {
        $projet = Projet::where('date_de_fin', '<', now())
                        ->whereNull('statut')
                        ->orderByRaw('DATEDIFF(now(), date_de_fin) DESC')
                        ->first();

        return response()->json($projet);
    }


}
