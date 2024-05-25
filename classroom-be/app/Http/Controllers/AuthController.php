<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle user login
     */
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        if (! Auth::attempt($data)) {
            return response()->json([
                'status' => false,
                'message' => 'User email or password wrong',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $user = Auth::user();
        match ($user->role) {
            'student' => $user->load('student'),
            'teacher' => $user->load('teacher')
        };
        $token = $user->createToken('main')->plainTextToken;

        return response()->json([
            'message' => 'User logged in successfully',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Handle user logout
     */
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response('', 204);
    }
}
