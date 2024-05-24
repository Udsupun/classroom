<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface GradeStudentsInterface
{
    /**
     * Get students by grade ID.
     */
    public function getStudentsByGradeId(int $gradeId): Collection;
}
