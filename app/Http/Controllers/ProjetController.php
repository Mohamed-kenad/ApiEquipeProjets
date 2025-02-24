<?php
namespace App\Http\Controllers;

use App\Http\Resources\ProjetResource;
use App\Models\Projet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JsonException;

class ProjetController extends Controller
{
    public function index()
    {
        $projets = Projet::all();
        return ProjetResource::collection($projets);
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|string|max:255',
            'date_de_debut' => 'required|date',
            'date_de_fin' => 'nullable|date|max:15',
        ]);

        $projet = Projet::create($request->all());
        return new ProjetResource($projet);
    }
        public function show($id)
    {
        
        $projet = Projet::findOrFail($id);

        return new ProjetResource($projet);
    }


    public function update(Request $request, $id) 
    { 
        $projet = Projet::find($id); 
        if (!$projet) { 
            return response()->json(['error' => 'Ressource introuvable'], 404); 
        } 
        $request->validate([ 
            'status' => 'nullable|string|max:25', 
            'date_de_debut' => 'required|date|max:40', 
            'date_de_fin' => 'required|date|max:40', 
        ]); 
        $projet->update($request->all()); 
        return new ProjetResource($projet); 
    } 

    public function destroy($id) 
    { 
        $projet = Projet::find($id); 
        if (!$projet) { 
            return response()->json(['error' => 'Ressource introuvable'], 404); 
        } 
        Projet::destroy($id); 
        return response()->json(["message" => "projet supprimée avec succès"], 200); 
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



    


    
    
    
    

    public function termine_avec_retard(Projet $projet)
    {
        if ($projet->date_de_fin < now()) {
            $projet->status = 'termine_avec_retard';
        } else {
            $projet->status = 'termine';
        }
        $projet->save();
    }

    public function retard_maximal(Projet $projet, $maxDelayInDays)
    {
        if ($projet->status == 'en retard') {
            $maxDelay = $projet->date_de_fin->addDays($maxDelayInDays);

            if (now() > $maxDelay) {
                $projet->status = 'retard_maximal';
                $projet->save();
            }
        }
    }
}
