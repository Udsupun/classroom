<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class TeacherController extends Controller
{
    /**
     * Take teacher classes
    */
    public function getStudentDetails()
    {
        $student = Auth::user();
        return response()->json([
            'message' => 'Teacher classes',
            'data' => $student
        ], Response::HTTP_OK);
    }
}
