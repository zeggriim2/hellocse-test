<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\ProfilController;
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

Route::post('/register', [AdminController::class, 'register']);
Route::post('/login', [AdminController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/profils', [ProfilController::class, 'create']);
    Route::put('/profils/{profil}', [ProfilController::class, 'update']);
    Route::delete('/profils/{profil}', [ProfilController::class, 'delete']);
});

Route::get('/profils', [ProfilController::class, 'index']);
