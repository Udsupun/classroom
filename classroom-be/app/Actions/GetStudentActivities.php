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
     * Controller method to handle the request and authorization.
     */
    public function asController(Student $student): Student
    {
        Gate::authorize('is-teacher');

        return $student;
    }

    /**
     * Response method to handle http response
     */
    public function jsonResponse(Student $student): JsonResponse
    {
        return response()->json([
            'message' => 'Student activities list',
            'data' => StudentActivityResource::make($student),
        ], Response::HTTP_OK);
    }
}
