<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\LecturesController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SpeakersController;
use App\Http\Controllers\SponsorsController;
use App\Http\Controllers\StagesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UsersHasLecturesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

 // registration, login, logout
Route::post('/register', [RegistrationController::class, 'register'])->middleware('guest:sanctum');
Route::post('login', LoginController::class)->middleware('guest:sanctum');
Route::get('/logout', function (Request $request) {
    return $request->user()->currentAccessToken()->delete();
})->middleware(['auth:sanctum']);

 // get user
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware(['auth:sanctum','abilities:show:user']);

// GET routes
Route::get('/comments',[CommentsController::class,'index']);
Route::get('/lectures',[LecturesController::class,'index']);
Route::get('/speakers',[SpeakersController::class,'index']);
Route::get('/sponsors',[SponsorsController::class,'index']);
Route::get('/stages',[StagesController::class,'index']);
Route::get('/users',[UsersController::class,'index']);
Route::get('/users-has-lectures',[UsersHasLecturesController::class,'index']);

// CREATE routes
Route::post('/create_speaker',[SpeakersController::class,'create']);
Route::post('/create_comment',[CommentsController::class,'create']);
Route::post('/create_lecture',[LecturesController::class,'create']);
Route::post('/create_sponsor',[SponsorsController::class,'create']);
Route::post('/create_stage',[StagesController::class,'create']);
Route::post('/create_user_has_lecture',[UsersHasLecturesController::class,'create']); // mozno nebude treba

// UPDATE ROUTES
Route::put('/update_speaker/{id}',[SpeakersController::class,'update']);
Route::put('/update_comment/{id}',[CommentsController::class,'update']);
Route::put('/update_lecture/{id}',[LecturesController::class,'update']);
Route::put('/update_sponsor/{id}',[SponsorsController::class,'update']);
Route::put('/update_stage/{id}',[StagesController::class,'update']);
Route::put('/update_user_has_lecture/{id}',[UsersHasLecturesController::class,'update']); // mozno nbude treba

// DELETE ROUTES
Route::delete('/delete_speaker/{id}',[SpeakersController::class,'delete']);
Route::delete('/delete_comment/{id}',[CommentsController::class,'delete']);
Route::delete('/delete_lecture/{id}',[LecturesController::class,'delete']);
Route::delete('/delete_sponsor/{id}',[SponsorsController::class,'delete']);
Route::delete('/delete_stage/{id}',[StagesController::class,'delete']);
Route::delete('/delete_user_has_lecture/{id}',[UsersHasLecturesController::class,'delete']); // mozno nebude treba


// dokoncit CRUD operacie pre ostatne entity, osetrit mazanie entit so vztahmi, momentalne neviem vymazat spekaera, ktory ma prideleny lecture

// prihlasenie usera do lecture
Route::middleware('auth:sanctum')->post('/register-lecture', [UsersHasLecturesController::class, 'register']);
Route::middleware('auth:sanctum')->post('/cancel-lecture', [UsersHasLecturesController::class, 'cancelRegistration']);
