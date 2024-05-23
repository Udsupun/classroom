<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Take teacher classes
    */
    public function getClasses()
    {
        return response()->json([
            'status' => true,
            'message' => 'Teacher classes',
            'data' => 
        ], Response::HTTP_OK);
    }
}
