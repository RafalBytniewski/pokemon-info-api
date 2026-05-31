<?php

namespace App\Http\Controllers;

use App\Models\BannedPokemon;
use Illuminate\Http\Request;

class BannedPokemonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => BannedPokemon::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'name' => strtolower($request->input('name'))
        ]);

        $request->validate([
            'name' => ['required', 'string', 'unique:banned_pokemon']
        ]);

        $pokemon = BannedPokemon::create([
            'name' => $request->input('name')
        ]);

        return response()->json([
            'message' => 'Pokemon added to banned',
            'data' => $pokemon
        ],201);       
    } 

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pokemon = BannedPokemon::findOrFail($id);
        $pokemon->delete();
        
        return response()->json([
            'message' => 'Deleted Succesfully'
        ], 200);
    }
}
