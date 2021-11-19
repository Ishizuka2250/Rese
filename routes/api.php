<?php

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ReserveController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\RestaurantGenleController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::apiResource('/v1/reserves', ReserveController::class);
Route::apiResource('/v1/favorites', FavoriteController::class);
Route::apiResource('/v1/restaurants/{restaurantID}/genles', RestaurantGenleController::class);

