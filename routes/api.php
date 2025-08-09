<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\StatistiqueController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Groupe2ZeroController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/2-0', [Groupe2ZeroController::class, 'store']);
Route::get('/2-0/{groupe}/matchs', [MatchController::class, 'index']);
Route::post('/2-0/{groupe}/matchs', [MatchController::class, 'store']);
Route::get('/matchs/{match}', [MatchController::class, 'show']);

Route::get('/matchs/{match}/equipes', [EquipeController::class, 'index']);
Route::post('/matchs/{match}/equipes', [EquipeController::class, 'store']);
Route::post('/equipes/{equipe}/joueurs', [EquipeController::class, 'addJoueur']);
Route::delete('/equipes/{equipe}/joueurs', [EquipeController::class, 'removeJoueur']);

Route::post('/matchs/{match}/statistiques', [StatistiqueController::class, 'storeOrUpdate']);
Route::get('/matchs/{match}/statistiques', [StatistiqueController::class, 'show']);

Route::get('/inscription', function (Request $request) {
    $groupeId = $request->query('groupe_id');
    // Passe ce paramètre à la vue inscription pour l'utiliser côté frontend
    return view('auth.register', ['groupe_id' => $groupeId]);
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/utilisateurs/pending', [AdminUserController::class, 'pending'])->name('admin.users.pending');
    Route::post('/admin/utilisateurs/{user}/valider', [AdminUserController::class, 'valider'])->name('admin.users.valider');
});
