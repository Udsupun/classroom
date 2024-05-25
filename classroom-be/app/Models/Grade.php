<?php

namespace App\Models;

use App\Modeles\Teacher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'name'];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_grades');
    }
}
