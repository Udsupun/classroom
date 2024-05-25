<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Lorisleiva\Actions\Concerns\AsAction;

class UserLogout
{
    use AsAction;

    public function handle(User $user): User
    {
        $user->currentAccessToken()->delete();

        return $user;
    }

    public function asController(Request $request): User
    {
        $user = $request->user();

        return $this->handle($user);
    }

    public function jsonResponse(): JsonResponse
    {
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
