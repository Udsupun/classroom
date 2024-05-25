<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'user_id', 'grade_id'];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * Student owned user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Student owned grade
     */
    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    /**
     * Student's activties
     */
    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class, 'student_activities');
    }
}
