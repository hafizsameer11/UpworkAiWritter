<?php

use App\Http\Controllers\BotController;
use App\Http\Controllers\NicheController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProposalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/bots', [BotController::class, 'all']);
Route::post('/bots/create', [BotController::class, 'create']);
Route::get('/bots/{id}', [BotController::class, 'get']);
Route::post('/bots/update/{id}', [BotController::class, 'update']);
Route::delete('/bots/delete/{id}', [BotController::class, 'delete']);
Route::get('/niches', [NicheController::class, 'all']);
Route::post('/niches/create', [NicheController::class, 'create']);
Route::get('/niches/{id}', [NicheController::class, 'get']);
Route::post('/niches/update/{id}', [NicheController::class, 'update']);
Route::delete('/niches/delete/{id}', [NicheController::class, 'delete']);
Route::get('/projects', [ProjectController::class, 'all']);
Route::get('/projects/{id}', [ProjectController::class, 'get']);
Route::post('/projects/create', [ProjectController::class, 'create']);
Route::post('/projects/update/{id}', [ProjectController::class, 'update']);
Route::delete('/projects/delete/{id}', [ProjectController::class, 'delete']);
Route::post('/proposals/create', [ProposalController::class, 'create']);
Route::get('/proposals', [ProposalController::class, 'all']);
Route::get('/proposals/{id}/{userId}', [ProposalController::class, 'get']);
