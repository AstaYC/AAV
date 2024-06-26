<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\voitureController;
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


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('/login', [AuthController::class , 'login']);
    Route::post('/register', [AuthController::class , 'register']);
    Route::post('/update', [AuthController::class , 'updateUser']);
    Route::post('/delete', [AuthController::class , 'deleteUser']);
    Route::post('/displayVoiture', [voitureController::class , 'display']);
    Route::post('/estimation', [voitureController::class , 'estimation']);
});

