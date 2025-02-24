<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personne;
use App\Http\Resources\PersonneResource;

/**
 * @OA\Info(
 *     title="API de gestion des personnes",
 *     version="1.0.0",
 *     description="Documentation de l'API pour gérer les personnes",
 * )
 * @OA\Tag(
 *     name="Personnes",
 *  description="Endpoints pour gérer les personnes"
 * )
 */
 
  
 
 class PersonneController extends Controller 
 { 
     /** 
      * @OA\Get( 
      *     path="/api/personnes", 
      *     summary="Récupérer toutes les personnes", 
      *     tags={"Personnes"}, 
      *     @OA\Response( 
      *         response=200, 
      *         description="Liste des personnes", 
      *         @OA\JsonContent( 
      *             type="array", 
      *             @OA\Items(ref="#/components/schemas/Personne") 
      *         ) 
      *     ) 
      * ) 
      */ 
     public function index() 
     { 
         $personnes = Personne::all(); 
         return PersonneResource::collection($personnes); 
     } 
  
     /** 
      * @OA\Get( 
      *     path="/api/personnes/{id}", 
      *     summary="Récupérer une personne par ID", 
      *     tags={"Personnes"}, 
      *     @OA\Parameter( 
      *         name="id", 
      *         in="path", 
      *         required=true, 
      *         description="ID de la personne", 
      *         @OA\Schema(type="integer") 
      *     ), 
      *     @OA\Response( 
      *         response=200, 
      *         description="Détails de la personne", 
      *         @OA\JsonContent(ref="#/components/schemas/Personne") 
      *     ), 
      *     @OA\Response(response=404, description="Personne non trouvée") 
      * ) 
      */ 
     public function show($id) 
     { 
         $personne = Personne::find($id); 
         if (!$personne) { 
             return response()->json(['error' => 'Ressource introuvable'], 404); 
         } 
         return new PersonneResource($personne); 
     } 
  
     /** 
      * @OA\Post( 
      *     path="/api/personnes", 
      *     summary="Créer une nouvelle personne", 
      *     tags={"Personnes"}, 
      *     @OA\RequestBody( 
      *         required=true, 
      *         @OA\JsonContent(ref="#/components/schemas/Personne") 
      *     ), 
      *     @OA\Response( 
      *         response=201, 
      *         description="Personne créée avec succès", 
      *         @OA\JsonContent(ref="#/components/schemas/Personne") 
      *     ) 
      * ) 
      */ 
     public function store(Request $request) 
     { 
         $request->validate([ 
             'nom' => 'required|string|max:255', 
             'prenom' => 'required|string|max:255', 
             'tele' => 'nullable|string|max:15', 
             'ville' => 'nullable|string|max:255', 
         ]); 
         $personne = Personne::create($request->all()); 
         return new PersonneResource($personne); 
     } 
  
     /** 
      * @OA\Put( 
      *     path="/api/personnes/{id}", 
      *     summary="Mettre à jour une personne", 
      *     tags={"Personnes"}, 
      *     @OA\Parameter( 
      *         name="id", 
      *         in="path", 
      *         required=true, 
      *         description="ID de la personne à mettre à jour", 
      *         @OA\Schema(type="integer") 
      *     ), 
      *     @OA\RequestBody( 
      *         required=true, 
      *         @OA\JsonContent(ref="#/components/schemas/Personne") 
      *     ), 
      *     @OA\Response( 
      *         response=200, 
      *         description="Personne mise à jour avec succès", 
      *         @OA\JsonContent(ref="#/components/schemas/Personne") 
      *     ), 
      *     @OA\Response(response=404, description="Personne non trouvée") 
      * ) 
      */ 
     public function update(Request $request, $id) 
     { 
         $personne = Personne::find($id); 
         if (!$personne) { 
             return response()->json(['error' => 'Ressource introuvable'], 404); 
         } 
         $request->validate([ 
             'nom' => 'required|string|max:255', 
             'prenom' => 'required|string|max:255', 
             'telephone' => 'nullable|string|max:15', 
             'ville' => 'nullable|string|max:255', 
         ]); 
         $personne->update($request->all()); 
         return new PersonneResource($personne); 
     } 
  
   
    /** 
     * @OA\Delete( 
     *     path="/api/personnes/{id}", 
     *     summary="Supprimer une personne", 
     *     tags={"Personnes"}, 
     *     @OA\Parameter( 
     *         name="id", 
     *         in="path", 
     *         required=true, 
     *         description="ID de la personne à supprimer", 
     *         @OA\Schema(type="integer") 
     *     ), 
     *     @OA\Response( 
     *         response=200, 
     *         description="Personne supprimée avec succès" 
     *     ), 
     *     @OA\Response(response=404, description="Personne non trouvée") 
     * ) 
     */ 
     public function destroy($id) 
     { 
         $personne = Personne::find($id); 
         if (!$personne) { 
             return response()->json(['error' => 'Ressource introuvable'], 404); 
         } 
         Personne::destroy($id); 
         return response()->json(["message" => "Personne supprimée avec succès"], 200); 
     } 

     
     public function getProjets($id)
     {
         $personne = Personne::findOrFail($id);
         return response()->json($personne->projets);
     }
 } 
