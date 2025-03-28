<?php

use App\Http\Controllers\LeagueMatchController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
/* 
Route::get('api/matches', [LeagueMatchController::class, 'index']);
Route::get('api/matches/{id}', [LeagueMatchController::class, 'show']);
Route::put('api/matches/{id}', [LeagueMatchController::class, 'update']);
Route::post('api/matches', [LeagueMatchController::class, 'store']);
Route::delete('api/matches/{id}', [LeagueMatchController::class, 'destroy']); */