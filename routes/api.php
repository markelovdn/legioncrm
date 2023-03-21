<?php

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

use Illuminate\Support\Facades\Route;

Route::resource('athletes-api', \App\Http\Controllers\Api\AthletesController::class)->middleware('auth:sanctum');
Route::get('competitors-export/{competition_id}', [\App\Http\Controllers\Api\CompetitorsExport::class, 'competitorsExport'])->middleware('auth:sanctum');
