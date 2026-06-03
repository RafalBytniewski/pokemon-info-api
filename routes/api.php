<?php

use App\Http\Controllers\BannedPokemonController;
use App\Http\Controllers\PokemonInfoController;
use App\Http\Middleware\CheckSecretKey;
use Illuminate\Support\Facades\Route;

Route::middleware([CheckSecretKey::class])->group(function() {
    Route::get('/banned', [BannedPokemonController::class, 'index'])->middleware(CheckSecretKey::class);
    Route::post('/banned', [BannedPokemonController::class, 'store']);
    Route::delete('/banned/{id}', [BannedPokemonController::class, 'destroy']);
});
Route::get('/pokemon', [PokemonInfoController:: class, 'getPokemonInfo']);