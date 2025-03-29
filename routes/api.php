<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeagueMatchController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::get('matches', [LeagueMatchController::class, 'index']);
Route::get('matches/{id}', [LeagueMatchController::class, 'show']);
Route::post('matches', [LeagueMatchController::class, 'store']);
Route::put('matches/{id}', [LeagueMatchController::class, 'update']);
Route::delete('matches/{id}', [LeagueMatchController::class, 'destroy']);
Route::patch('matches/{id}/goals', [LeagueMatchController::class, 'addGoal']);
Route::patch('matches/{id}/yellowcards', [LeagueMatchController::class, 'addYellowCard']);
Route::patch('matches/{id}/redcards', [LeagueMatchController::class, 'addRedCard']);
Route::patch('matches/{id}/extratime', [LeagueMatchController::class, 'addExtraTime']);