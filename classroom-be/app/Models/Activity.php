<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'name', 'subject', 'score'];

    /**
     * Activities owned by student connected by student activities
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'student_activities');
    }
}
