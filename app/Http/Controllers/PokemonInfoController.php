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

            $dbPokemons = PokemonInfo::get();
            if ($dbPokemons->isNotEmpty()) {
                foreach ($dbPokemons as $dbPokemon) {
                    $result[] = [
                        'name' => $dbPokemon->name,
                        'height' => $dbPokemon->height,
                        'weight' => $dbPokemon->weight,
                        'source' => 'database'
                    ];
                }
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
                'source' => 'PokeAPI'
            ];
        }

        return response()->json([
            'data' => $result,
        ]);
    }
    public function show(int $id)
    {
        $pokemon = PokemonInfo::findOrFail($id);

        return response()->json([
            'name' => $pokemon->name,
            'height' => $pokemon->height,
            'weight' => $pokemon->weight
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['string', 'required'],
            'height' => ['integer', 'required', 'min:1'],
            'weight' => ['integer', 'required', 'min:1']
        ]);

        $name = strtolower($request->input('name'));
        $validated['name'] = $name;

        if (PokemonInfo::where('name', $name)->exists()) {
            return response()->json([
                'message' => 'Pokemon already exists in database'
            ], 409);
        }
        $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$name}");
        if ($response->ok()) {
            return response()->json([
                'message' => 'Pokemon already exists in PokeAPI'
            ], 409);
        }

        if (!$response->notFound()) {
            return response()->json([
                'message' => 'Server error'
            ], 503);
        }

        PokemonInfo::create($validated);
        return response()->json([
            'message' => 'Pokemon added'
        ], 201);
    }
    public function destroy($id)
    {
        $pokemon = PokemonInfo::findOrFail($id);
        $pokemon->delete();

        return response()->json([
            'message' => 'Pokemon succesfully deleted'
        ], 200);
    }
    public function update(Request $request, int $id){
        $pokemon = PokemonInfo::findOrFail($id);

        $validated = $request->validate([
            'name' => ['string'],
            'height' => ['integer', 'min:1',],
            'weight' => ['integer', 'min:1',]
        ]);
        
        if (isset($validated['name'])) {
            $validated['name'] = strtolower($validated['name']);
        }

        $pokemon->update($validated);

        return response()->json([
            'message'=>'Updated succesfully',
            'data'=> $pokemon
        ],201);
    }
}
