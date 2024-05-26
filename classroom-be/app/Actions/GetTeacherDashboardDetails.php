<?php

namespace App\Actions;

use App\Http\Resources\GradeResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Lorisleiva\Actions\Concerns\AsAction;

class GetTeacherDashboardDetails
{
    use AsAction;

    /**
     * Handle the fetc user logic.
     */
    public function handle(): User
    {
        return Auth::user();
    }

    /**
     * Controller method to handle the request and authorization.
     */
    public function asController(): User
    {
        Gate::authorize('is-teacher');

        return $this->handle();
    }

    /**
     * Response method to handle http response
     */
    public function jsonResponse(User $user): JsonResponse
    {
        return response()->json([
            'message' => 'Dashboard details',
            'data' => GradeResource::collection($user->teacher->grades),
        ], Response::HTTP_OK);
    }
}
