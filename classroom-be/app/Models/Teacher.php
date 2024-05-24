<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TeacherGrade;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function grades()
    {
        return $this->belongsToMany(Grade::class, 'teacher_grades');
    }
}
