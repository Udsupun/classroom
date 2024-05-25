<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentActivity extends Model
{
    use HasFactory;

    protected $table = 'student_activities';

    protected $fillable = ['student_id', 'activity_id', 'score'];

    protected $with = ['activity'];

    /**
     * Student activity owned student
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Student activity referes activity
     */
    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }
}
