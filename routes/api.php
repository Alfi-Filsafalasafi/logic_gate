<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MateriApiController;
use App\Http\Controllers\Api\LogMateriApiController;
use App\Http\Controllers\Api\JobsheetApiController;
use App\Http\Controllers\Api\LogJobsheetApiController;
use App\Http\Controllers\Api\AddApiController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/profile', [AuthController::class, 'updateProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/materis', [MateriApiController::class, 'index']);
    Route::get('/materis/new', [MateriApiController::class, 'new']);
    Route::get('/materis/{id}', [MateriApiController::class, 'show']);
    Route::post('/log-materis', [LogMateriApiController::class, 'store']);
    Route::get('/jobsheets', [JobsheetApiController::class, 'index']);
    Route::get('/jobsheets/{id}', [JobsheetApiController::class, 'show']);
    Route::post('/log-jobsheets', [LogJobsheetApiController::class, 'store']);
    Route::get('/adds', [AddApiController::class, 'index']);

});