<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Http\Resources\StudentDetailsResource;

class TeacherController extends Controller
{
    /**
     * Take teacher classes
    */
    public function getStudentDetails()
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
            'data' => StudentDetailsResource::make($user)
        ], Response::HTTP_OK);
    }
}
