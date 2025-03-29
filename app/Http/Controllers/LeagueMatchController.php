<?php

namespace App\Http\Controllers;

use App\Models\LeagueMatch;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="League Matches API",
 *     version="1.0.0",
 *     description="Documentación Swagger para la API de gestión de partidos de liga"
 * )
 *
 * @OA\Server(
 *     url="/api",
 *     description="API base"
 * )
 */
class LeagueMatchController extends Controller
{
    /**
     * @OA\Get(
     *     path="/matches",
     *     summary="Obtener todos los partidos.",
     *     tags={"Matches"},
     *     @OA\Response(response=200, description="Lista de partidos."),
     *     @OA\Response(response=404, description="No se encontraron registros.")
     * )
     */
    public function index()
    {
        $matches = LeagueMatch::all();

        if (!$matches) {
            return response()->json(['message' => 'No se encontraron registros'], 404);
        }

        return response()->json($matches);
    }

    /**
     * @OA\Get(
     *     path="/matches/{id}",
     *     summary="Obtener un partido por ID.",
     *     tags={"Matches"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Partido encontrado."),
     *     @OA\Response(response=404, description="Partido no encontrado.")
     * )
     */
    public function show($id) 
    {
        $match = LeagueMatch::find($id);

        if (!$match) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        return response()->json($match);
    }

    /**
     * @OA\Post(
     *     path="/matches",
     *     summary="Crear un nuevo partido.",
     *     tags={"Matches"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"homeTeam", "awayTeam", "matchDate"},
     *             @OA\Property(property="homeTeam", type="string"),
     *             @OA\Property(property="awayTeam", type="string"),
     *             @OA\Property(property="matchDate", type="string", format="date")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Partido creado."),
     *     @OA\Response(response=422, description="Error de validación.")
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/matches/{id}",
     *     summary="Actualizar un partido existente.",
     *     tags={"Matches"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="homeTeam", type="string"),
     *             @OA\Property(property="awayTeam", type="string"),
     *             @OA\Property(property="matchDate", type="string", format="date")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Partido actualizado."),
     *     @OA\Response(response=404, description="Partido no encontrado.")
     * )
     */
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
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/matches/{id}",
     *     summary="Eliminar un partido.",
     *     tags={"Matches"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Partido eliminado."),
     *     @OA\Response(response=404, description="Partido no encontrado.")
     * )
     */
    public function destroy($id)
    {
        $match = LeagueMatch::find($id);

        if (!$match) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        $match->delete();

        return response()->json(['message' => 'Registro eliminado con exito'], 200);
    }

    /**
     * @OA\Patch(
     *     path="/matches/{id}/goals",
     *     summary="Actualizar los goles de un partido.",
     *     tags={"Matches"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Goles actualizados."),
     *     @OA\Response(response=404, description="Partido no encontrado.")
     * )
     */
    public function addGoal($id)
    {
        return $this->incrementField($id, 'goals', 1);
    }

    /**
     * @OA\Patch(
     *     path="/matches/{id}/yellowcards",
     *     summary="Registrar una tarjeta amarilla.",
     *     tags={"Matches"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Tarjeta amarilla registrada."),
     *     @OA\Response(response=404, description="Partido no encontrado.")
     * )
     */
    public function addYellowCard($id)
    {
        return $this->incrementField($id, 'yellowcards', 1);
    }

    /**
     * @OA\Patch(
     *     path="/matches/{id}/redcards",
     *     summary="Registrar una tarjeta roja.",
     *     tags={"Matches"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Tarjeta roja registrada."),
     *     @OA\Response(response=404, description="Partido no encontrado.")
     * )
     */
    public function addRedCard($id)
    {
        return $this->incrementField($id, 'redcards', 1);
    }

    /**
     * @OA\Patch(
     *     path="/matches/{id}/extratime",
     *     summary="Registrar el tiempo extra del partido.",
     *     tags={"Matches"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Tiempo extra registrado."),
     *     @OA\Response(response=404, description="Partido no encontrado.")
     * )
     */
    public function addExtraTime($id)
    {
        return $this->incrementField($id, 'extratime', 5);
    }

    private function incrementField($id, $field, $amount)
    {
        $match = LeagueMatch::find($id);

        if (!$match) {
            return response()->json(['message' => 'Partido no encontrado'], 404);
        }

        $match->$field += $amount;
        $match->save();

        return response()->json([
            'message' => $field . ' actualizado',
            'match' => $match
        ], 200);
    }
}