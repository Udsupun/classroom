<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Activity;
use App\Models\Student;

class StudentSubmission extends Model
{
    use HasFactory;

    protected $table = 'student_submissions';
    protected $fillable = ['student_id', 'activity_id'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
