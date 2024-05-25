<?php

use App\Actions\GetGradeStudents;
use App\Actions\GetStudentActivities;
use App\Actions\GetStudentDashboardDetails;
use App\Actions\GetTeacherDashboardDetails;
use App\Actions\UserLogin;
use App\Actions\UserLogout;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    //Student routes
    Route::get('/dashboard-details', GetStudentDashboardDetails::class);

    // Teacher routes
    Route::get('/teacher-classes', GetTeacherDashboardDetails::class);
    Route::get('/grade-students/{grade}', GetGradeStudents::class);
    Route::get('/student-activities/{student}', GetStudentActivities::class);

    // Route::post('logout', [AuthController::class, 'logout']);
    Route::post('logout', UserLogout::class);
});

Route::post('login', UserLogin::class);
