<?php

namespace App\Http\Controllers;

use App\Models\LeagueMatch;
use Illuminate\Http\Request;

class LeagueMatchController extends Controller
{
    public function index()
    {
        $matches = LeagueMatch::all();

        if (!$matches) {
            return response()->json(['message' => 'No se encontraron registros'], 404);
        }

        return response()->json($matches);
    }

    public function show($id) 
    {
        $match = LeagueMatch::find($id);

        if (!$match) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        return response()->json($match);
    }

    public function store(Request $request)
    {
        $request->validate([
            'homeTeam' => 'required',
            'awayTeam' => 'required',
            'matchDate' => 'required|date'
        ]);

        $match             = new LeagueMatch();
        $match->home_team  = $request->input('homeTeam');
        $match->away_team  = $request->input('awayTeam');
        $match->match_date = $request->input('matchDate');
        $match->save();

        return response()->json([
            'message' => 'Registro creado con exito',
            'match' => $match
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $match = LeagueMatch::find($id);

        if (!$match) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        if ($request->has('homeTeam')) {
            $match->home_team = $request->input('homeTeam');
        }
        if ($request->has('awayTeam')) {
            $match->away_team = $request->input('awayTeam');
        }
        if ($request->has('matchDate')) {
            $match->match_date = $request->input('matchDate');
        }

        $match->save();

        return response()->json([
            'message' => 'Registro actualizado con exito',
            'match' => $match
        ]);
    }

    public function destroy($id)
    {
        $match = LeagueMatch::find($id);

        if (!$match) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        $match->delete();

        return response()->json(['message' => 'Registro eliminado con exito']);
    }
}