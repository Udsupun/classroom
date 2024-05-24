<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Grade;
use App\Models\Activity;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'user_id', 'grade_id'];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'student_activities');
    }
}
