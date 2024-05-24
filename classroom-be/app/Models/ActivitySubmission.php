<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Activity;
use App\Models\Student;

class ActivitySubmission extends Model
{
    use HasFactory;

    protected $table = 'activity_submissions';
    protected $fillable = ['student_id', 'activity_id', 'score'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
