<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeacherController;

Route::middleware(['auth:sanctum'])->group(function() {
    Route::post('logout',[AuthController::class,'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/student-details', [TeacherController::class, 'getStudentDetails']);
});

Route::post('login', [AuthController::class, 'login']);
