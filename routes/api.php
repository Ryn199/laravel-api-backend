<?php

use App\Http\Controllers\Api\AnimeController;
use App\Http\Controllers\AuthController;
use App\Http\Resources\AnimeResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('posts', AnimeController::class);

Route::post('login', [AuthController::class, 'login']);
