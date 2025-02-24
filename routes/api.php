<?php

use App\Http\Controllers\AffectationController;
use App\Http\Controllers\ProjetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\PersonneController;

Route::apiResource('personnes', PersonneController::class);

Route::apiResource('projets', ProjetController::class);





Route::post('projets/{projet_id}/assign', [AffectationController::class, 'Affectation']);
Route::post('projets/{projet_id}/remove', [AffectationController::class, 'removePersonneFromProjet']);


Route::get('projets/closed', [ProjetController::class, 'projetsTermines']);

Route::get('projets/{id}/personnes', [ProjetController::class, 'getPersonnes']);
Route::get('personnes/{id}/projets', [PersonneController::class, 'getProjets']);
Route::get('projets/en-retard', [ProjetController::class, 'projetsEnRetard']);
Route::get('projets/termine-en-retard', [ProjetController::class, 'projetsTerminesEnRetard']);
Route::get('projets/retard-max', [ProjetController::class, 'projetRetardMax']);

