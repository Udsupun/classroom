<?php

namespace App\Actions;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;

class UserLogin
{
    use AsAction;

    /**
     * Handle the login logic.
     */
    public function handle(array $data): ?User
    {
        if (! Auth::attempt($data)) {
            return null;
        }

        return Auth::user();
    }

    /**
     * Controller method to handle the request.
     */
    public function asController(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $this->handle($data);

        if (! $user) {
            return response()->json([
                'status' => false,
                'message' => 'User email or password wrong',
            ], Response::HTTP_UNAUTHORIZED);
        }

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
}
