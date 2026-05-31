<?php

use App\Http\Controllers\BannedPokemonController;
/* use Illuminate\Http\Request; */
use Illuminate\Support\Facades\Route;

/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
 */


Route::get('/banned', [BannedPokemonController::class, 'index']);
Route::post('/banned', [BannedPokemonController::class, 'store']);