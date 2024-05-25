<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeacherController;
use App\Actions\GetStudentActivities;
use App\Actions\GetGradeStudents;
use App\Actions\GetTeacherDashboardDetails;
use App\Actions\GetStudentDashboardDetails;

Route::middleware(['auth:sanctum'])->group(function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    //Student routes
    Route::get('/dashboard-details', GetStudentDashboardDetails::class);

    // Teacher routes
    // Route::get('/teacher-classes', [TeacherController::class, 'getTeacherClasses']);
    Route::get('/teacher-classes', GetTeacherDashboardDetails::class);
    Route::get('/grade-students/{grade}', GetGradeStudents::class);
    Route::get('/student-activities/{student}', GetStudentActivities::class);

    Route::post('logout',[AuthController::class,'logout']);
});

Route::post('login', [AuthController::class, 'login']);
