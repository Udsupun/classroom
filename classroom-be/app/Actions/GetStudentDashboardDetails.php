<?php

namespace App\Actions;

use App\Contracts\StudentDashboardDetailsInterface;
use App\Http\Resources\StudentDashboardDetailsResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Lorisleiva\Actions\Concerns\AsAction;

class GetStudentDashboardDetails implements StudentDashboardDetailsInterface
{
    use AsAction;

    public function handle(): User
    {
        Gate::authorize('is-student');

        return Auth::user();
    }

    public function jsonResponse(User $user): JsonResponse
    {
        return response()->json([
            'message' => 'Dashboard details',
            'data' => StudentDashboardDetailsResource::make($user),
        ], Response::HTTP_OK);
    }
}
