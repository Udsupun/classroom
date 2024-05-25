<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Http\Resources\StudentDetailsResource;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\GradeResource;
use App\Http\Resources\StudentResource;
use App\Http\Resources\UserResource;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Support\Facades\Gate;

class TeacherController extends Controller
{
    /**
     * Take teacher classes
    */
    public function getStudentDashboardDetails()
    {
        $user = Auth::user();
        if ($user->role != 'student') {
            return response()->json([
                'status' => false,
                'message' => 'Teacher cannot access this page.',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'message' => 'Student profile details and activities',
            'data' => [
                'details' => UserResource::make($user),
                'student_id' => $user->student->uuid,
                'grade' => GradeResource::make($user->student->grade),
                'activities' =>ActivityResource::collection($user->student->activities)
            ]
        ], Response::HTTP_OK);
    }
}
