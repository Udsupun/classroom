<?php

namespace App\Actions;

use App\Contracts\TeacherDashboardDetailsInterface;
use App\Http\Resources\GradeResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Lorisleiva\Actions\Concerns\AsAction;

class GetTeacherDashboardDetails implements TeacherDashboardDetailsInterface
{
    use AsAction;

    public function handle(): User
    {
        Gate::authorize('is-teacher');

        return Auth::user();
    }

    public function jsonResponse(User $user): JsonResponse
    {
        return response()->json([
            'message' => 'Dashboard details',
            'data' => GradeResource::collection($user->teacher->grades),
        ], Response::HTTP_OK);
    }
}
