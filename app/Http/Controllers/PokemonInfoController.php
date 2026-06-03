<?php

namespace App\Http\Controllers;

use App\Models\BannedPokemon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PokemonInfoController extends Controller
{
    public function getPokemonInfo(Request $request)
    {

        $validated = $request->validate([
            'pokemons' => ['required', 'array', 'min:1'],
            'pokemons.*' => ['required', 'string', 'distinct']
        ]);

        $pokemons = $validated['pokemons'];
        $result = [];

        foreach ($pokemons as $pokemon) {
            $pokemonName = strtolower($pokemon);
            if (BannedPokemon::where('name', $pokemonName)->exists()) {
                $result[] = [
                    'pokemon' => $pokemonName,
                    'message' => "Pokemon $pokemonName is banned"
                ];
                continue;
            }
            $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$pokemonName}");

            if ($response->failed()) {
                $result[] = [
                    'name' => $pokemonName,
                    'error' => 'Pokemon not found',
                ];
                continue;
            }

            $pokemon = $response->json();

            $result[] = [
                'name' => $pokemon['name'],
                'height' => $pokemon['height'],
                'weight' => $pokemon['weight'],
            ];
        }

        return response()->json([
            'data' => $result,
        ]);
    }
}
