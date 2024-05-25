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
use Lorisleiva\Actions\Concerns\AsAction;

class GetGradeStudents implements GradeStudentsInterface
{
    use AsAction;

    public function handle(Grade $grade): array
    {
        $students = $this->getStudentsByGradeId($grade->id);

        return [
            'grade' => GradeResource::make($grade),
            'students' => StudentResource::collection($students),
        ];
    }

    public function getStudentsByGradeId(int $gradeId): Collection
    {
        return Student::where('grade_id', $gradeId)->get();
    }

    public function jsonResponse(array $data): JsonResponse
    {
        return response()->json([
            'message' => 'Grade students list',
            'data' => $data,
        ], Response::HTTP_OK);
    }
}
