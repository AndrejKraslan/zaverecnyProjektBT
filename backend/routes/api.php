<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;


Route::post('login', LoginController::class)->middleware('guest:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware(['auth:sanctum','abilities:show:user']);

Route::get('/logout', function (Request $request) {
    return $request->user()->currentAccessToken()->delete();
})->middleware(['auth:sanctum']);
