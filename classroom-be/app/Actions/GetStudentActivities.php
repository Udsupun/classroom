<?php

namespace App\Actions;

use App\Http\Resources\StudentActivityResource;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Lorisleiva\Actions\Concerns\AsAction;

class GetStudentActivities
{
    use AsAction;

    /**
     * Handle get students by grade id logic.
     */
    public function handle(Student $student): StudentActivityResource
    {
        return StudentActivityResource::make($student);
    }

    /**
     * Controller method to handle the request and authorization.
     */
    public function asController(Student $student): StudentActivityResource
    {
        Gate::authorize('is-teacher');

        return $this->handle($student);
    }

    /**
     * Response method to handle http response
     */
    public function jsonResponse(StudentActivityResource $data): JsonResponse
    {
        return response()->json([
            'message' => 'Student activities list',
            'data' => $data,
        ], Response::HTTP_OK);
    }
}
