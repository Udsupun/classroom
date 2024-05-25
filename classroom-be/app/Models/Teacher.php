<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'user_id'];

    /**
     * Teacher belongs user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Teacher can teach in many grades
     */
    public function grades(): BelongsToMany
    {
        return $this->belongsToMany(Grade::class, 'teacher_grades');
    }
}
