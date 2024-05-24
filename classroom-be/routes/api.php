<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeacherController;
use App\Actions\GetStudentActivities;

Route::middleware(['auth:sanctum'])->group(function() {
    Route::post('logout',[AuthController::class,'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/dashboard-details', [TeacherController::class, 'getStudentDashboardDetails']);

    // Teacher routes
    Route::get('/teacher-classes', [TeacherController::class, 'getTeacherClasses']);
    Route::get('/grade-students/{gradeUuid}', [TeacherController::class, 'getGradeStudents']);
    // Route::get('/student-activities/{studentUuid}', [TeacherController::class, 'getStudentActivities']);
    Route::get('/student-activities/{studentUuid}', GetStudentActivities::class);
});

Route::post('login', [AuthController::class, 'login']);
