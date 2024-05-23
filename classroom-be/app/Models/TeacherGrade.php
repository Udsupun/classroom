<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;
use App\Models\Grade;

class TeacherGrade extends Model
{
    use HasFactory;

    protected $table = 'teacher_grades';
    protected $fillable = ['teacher_id', 'grade_id'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
