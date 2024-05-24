<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Handle user login
    */
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->firstOrFail();
        Auth::guard($user->role)->attempt($data);

        $user = Auth::guard($user->role)->user();

        if ($user) {
            $token = $user->createToken('main')->plainTextToken;
            return response()->json([
                'message' => 'User registerd',
                'data' => [
                    'user' => $user,
                    'token' => $token
                ]
            ], Response::HTTP_OK);
        }






        // if (!Auth::attempt($data)){
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'User email or password wrong',
        //     ], Response::HTTP_UNAUTHORIZED);
        // };
        $user = Auth::user();
        // match ($user->role) {
        //     'student' => $user->load('student'),
        //     'teacher' => $user->load('teacher')
        // };
        // if ($user->role === 'student') {
        //     $user->load('student');
        // } elseif ($user->role === 'teacher') {
        //     $user->load('teacher');
        // }
        $token = $user->createToken('main')->plainTextToken;
        return response()->json([
            'message' => 'User registerd',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ], Response::HTTP_OK);
    }

    /**
     * Handle user logout
    */
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return response('',204);
    }
}
