<?php

namespace App\Actions;

use App\Http\Resources\StudentActivityResource;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\Gate;

class GetStudentActivities
{
    use AsAction;

    public function handle(Student $student): Student
    {
        Gate::authorize('is-teacher');

        return $student;
    }

    public function asController(Student $student): Student
    {
        Gate::authorize('is-teacher');

        return $this->handle($student);
    }

    public function jsonResponse(Student $student): JsonResponse
    {
        return response()->json([
            'message' => 'Student activities list',
            'data' => StudentActivityResource::make($student),
        ], Response::HTTP_OK);
    }
}
