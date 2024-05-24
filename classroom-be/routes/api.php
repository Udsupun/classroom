<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeacherController;
use App\Actions\GetStudentActivities;
use App\Actions\GetGradeStudents;

Route::middleware(['auth:sanctum'])->group(function() {
    Route::post('logout',[AuthController::class,'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/dashboard-details', [TeacherController::class, 'getStudentDashboardDetails']);

    // Teacher routes
    Route::get('/teacher-classes', [TeacherController::class, 'getTeacherClasses']);
    Route::get('/grade-students/{grade}', GetGradeStudents::class);
    Route::get('/student-activities/{student}', GetStudentActivities::class);
});

Route::post('login', [AuthController::class, 'login']);
