<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Contracts\GradeInterface;

class Grade extends Model implements GradeInterface
{
    use HasFactory;

    protected $fillable = ['uuid', 'name'];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * Grade having many students
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Grade belongs to teacher connected by teacher grades
     */
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'teacher_grades');
    }
}
