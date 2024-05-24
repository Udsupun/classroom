<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Activity;
use App\Models\Student;

class StudentActivity extends Model
{
    use HasFactory;

    protected $table = 'student_activities';
    protected $fillable = ['student_id', 'activity_id', 'score'];

    protected $with = ['activity'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
