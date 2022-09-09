<?php

use App\Http\Controllers\PositionController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/users', UserController::class)
    ->middleware('user')->middleware('auth:sanctum')
    ->only('store');

Route::apiResource('/users', UserController::class)
    ->middleware('user')
    ->only('show', 'index');

Route::apiResource('/positions', PositionController::class)
    ->middleware('position')
    ->only('index');

Route::any('positions/{position}', function () {
    return response()->json([
        'status' => 'false',
        'message' => 'Page not found',
    ], 404);
})->where('position', '.*');

Route::get('/token', [TokenController::class, 'index']);



