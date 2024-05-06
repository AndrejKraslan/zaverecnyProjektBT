<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\LecturesController;
use App\Http\Controllers\SpeakersController;
use App\Http\Controllers\SponsorsController;
use App\Http\Controllers\StagesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UsersHasLecturesController;
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

Route::get('/comments',[CommentsController::class,'test']);
Route::get('/lectures',[LecturesController::class,'test']);
Route::get('/speakers',[SpeakersController::class,'test']);
Route::get('/sponsors',[SponsorsController::class,'test']);
Route::get('/stages',[StagesController::class,'test']);
Route::get('/users',[UsersController::class,'test']);
Route::get('/users-has-lectures',[UsersHasLecturesController::class,'test']);
