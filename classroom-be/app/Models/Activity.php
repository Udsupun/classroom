<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'name', 'subject', 'score'];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_activities');
    }
}
