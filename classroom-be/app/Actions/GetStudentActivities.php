<?php

namespace App\Actions;

use App\Contracts\StudentActivitiesInterface;
use App\Http\Resources\StudentActivityResource;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Lorisleiva\Actions\Concerns\AsAction;

class GetStudentActivities implements StudentActivitiesInterface
{
    use AsAction;

    public function handle(Student $student): Student
    {
        return $student;
    }

    public function jsonResponse(Student $student): JsonResponse
    {
        return response()->json([
            'message' => 'Student activities list',
            'data' => StudentActivityResource::make($student),
        ], Response::HTTP_OK);
    }
}
