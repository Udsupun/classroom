<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherGrade extends Model
{
    use HasFactory;

    protected $table = 'teacher_grades';

    protected $fillable = ['teacher_id', 'grade_id'];

    public $timestamps = false;

    /**
     * Teacher grade owned teacher
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Teacher grade owned grade
     */
    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }
}
