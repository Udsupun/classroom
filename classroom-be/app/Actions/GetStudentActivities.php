<?php

namespace App\Actions;

use App\Contracts\StudentActivitiesInterface;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\Student;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\GradeResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class GetStudentActivities implements StudentActivitiesInterface
{
    use AsAction;

    public function handle(String $studentUuid): Student
    {
        return $student = $this->getStudentByUuid($studentUuid);
    }

    /**
     * Get a student by UUID.
     */
    public function getStudentByUuid(string $studentUuid): Student
    {
        return Student::where('uuid', $studentUuid)->firstOrFail();
    }

    public function jsonResponse(Student $student): JsonResponse
    {
        return response()->json([
            'message' => 'Student activities list',
            'data' => [
                'details' => UserResource::make($student->user),
                'student_id' => $student->uuid,
                'grade' => GradeResource::make($student->grade),
                'activities' =>ActivityResource::collection($student->activities)
            ]
        ], Response::HTTP_OK);
    }
}
