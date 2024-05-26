<?php

namespace App\Actions;

use App\Http\Resources\StudentDashboardDetailsResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Lorisleiva\Actions\Concerns\AsAction;

class GetStudentDashboardDetails
{
    use AsAction;

    /**
     * Handle the fetch user logic.
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
        Gate::authorize('is-student');

        return $this->handle();
    }

    /**
     * Response method to handle http response
     */
    public function jsonResponse(User $user): JsonResponse
    {
        return response()->json([
            'message' => 'Dashboard details',
            'data' => StudentDashboardDetailsResource::make($user),
        ], Response::HTTP_OK);
    }
}
