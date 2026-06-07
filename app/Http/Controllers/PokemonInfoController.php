<?php

namespace App\Http\Controllers;

use App\Models\BannedPokemon;
use App\Models\PokemonInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use function PHPUnit\Framework\isEmpty;

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

    public function store(Request $request){
        $validated = $request->validate([
            'name' => ['string', 'required'],
            'height' => ['integer', 'required', 'min:1'],
            'weight' => ['integer', 'required', 'min:1']
        ]);

        $name = strtolower($request->input('name'));
        $validated['name'] = $name;

        if(PokemonInfo::where('name', $name)->exists()){
            return response()->json([
                'message' => 'Pokemon already exists in database'
            ],409);
        }
        $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$name}");
        if($response->ok()){
            return response()->json([
                'message' => 'Pokemon already exists in PokeAPI'
            ], 409);
        }

        if(!$response->notFound()){
            return response()->json([
                'message' => 'Server error'
            ], 503);
        }

        PokemonInfo::create($validated);
        return response()->json([
            'message' => 'Pokemon added'
        ],201);
    }
}
