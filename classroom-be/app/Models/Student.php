<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Grade;
use App\Models\ActivitySubmission;

class Student extends User
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = ['user_id', 'grade_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function class()
    {
        return $this->belongsTo(Grade::class);
    }

    public function activities()
    {
        return $this->hasMany(ActivitySubmission::class);
    }
}
