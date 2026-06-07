<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PokemonInfo extends Model
{
    protected $fillable = [
        'name',
        'height',
        'weight'
    ];
}
