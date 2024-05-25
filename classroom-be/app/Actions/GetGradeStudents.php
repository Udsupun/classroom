<?php

namespace App\Actions;

use App\Contracts\GradeStudentsInterface;
use App\Http\Resources\GradeResource;
use App\Http\Resources\StudentResource;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGradeStudents implements GradeStudentsInterface
{
    use AsAction;

    /**
     * Handle get students by grade id logic.
     */
    public function handle(Grade $grade): array
    {
        $students = $this->getStudentsByGradeId($grade->id);

        return [
            'grade' => GradeResource::make($grade),
            'students' => StudentResource::collection($students),
        ];
    }

    /**
     * Controller method to handle the request and authorization.
     */
    public function asController(Grade $grade): array
    {
        Gate::authorize('is-teacher');

        return $this->handle($grade);
    }

    /**
     * Get student grade by id
     */
    public function getStudentsByGradeId(int $gradeId): Collection
    {
        return Student::where('grade_id', $gradeId)->get();
    }

    /**
     * Response method to handle http response
     */
    public function jsonResponse(array $data): JsonResponse
    {
        return response()->json([
            'message' => 'Grade students list',
            'data' => $data,
        ], Response::HTTP_OK);
    }
}
