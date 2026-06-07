<?php

use App\Http\Controllers\BannedPokemonController;
use App\Http\Controllers\PokemonInfoController;
use App\Http\Middleware\CheckSecretKey;
use Illuminate\Support\Facades\Route;

Route::middleware([CheckSecretKey::class])->group(function() {
    Route::get('/banned', [BannedPokemonController::class, 'index']);
    Route::post('/banned', [BannedPokemonController::class, 'store']);
    Route::delete('/banned/{id}', [BannedPokemonController::class, 'destroy']);
    Route::get('/pokemon/{id}', [PokemonInfoController::class, 'show']);
    Route::post('/pokemon', [PokemonInfoController::class, 'store']);
    Route::delete('/pokemon/{id}', [PokemonInfoController::class, 'destroy']);
    Route::put('/pokemon/{id}', [PokemonInfoController::class, 'update']);
});
Route::get('/pokemon', [PokemonInfoController:: class, 'getPokemonInfo']);