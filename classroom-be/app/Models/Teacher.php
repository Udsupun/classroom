<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use App\Models\Scopes\TeacherScope;

#[ScopedBy([TeacherScope::class])]
class Teacher extends User
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = ['user_id', 'subject'];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
