<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle user login
     */
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        if (!Auth::attempt($data)){
            return response()->json([
                'status' => false,
                'message' => 'User email or password wrong',
            ], Response::HTTP_UNAUTHORIZED);
        };
        $user = Auth::user();
        $token = $user->create_token('main')->plainTextToken;
        return response()->json([
            'status' => true,
            'message' => 'User registerd',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ], Response::HTTP_OK);
    }
}