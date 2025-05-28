<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('blogs',BlogController::class);
Route::apiResource('Events',EventController::class)->middleware('auth:sanctum');;
Route::apiResource('Announcements',AnnouncementController::class)->middleware('auth:sanctum');;
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
Route::get('/Dashboard',[UserController::class,'index'])->middleware('auth:sanctum');
Route::put('/Dashboard/{user}',[UserController::class,'accept'])->middleware('auth:sanctum');
Route::delete('/Dashboard/{user}',[UserController::class,'deny'])->middleware('auth:sanctum');
Route::get('/allEvents',[UserController::class,'events'])->middleware('auth:sanctum');
Route::get('/allAnnouncements',[UserController::class,'announcements'])->middleware('auth:sanctum');




