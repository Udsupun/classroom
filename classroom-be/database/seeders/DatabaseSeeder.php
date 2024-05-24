<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Student;
use App\Models\Grade;
use App\Models\Teacher;
use App\Models\TeacherGrade;
use App\Models\StudentActivity;
use App\Models\Activity;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('students')->truncate();
        DB::table('grades')->truncate();
        DB::table('teachers')->truncate();
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create additional random teachers
        User::factory(5)->create(['role' => 'teacher'])->each(function ($user) {
            Teacher::factory()->create(['user_id' => $user->id]);
        });

        // Create specific grades
        $names = ['Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10'];

        foreach ($names as $name) {
            $grade = Grade::factory()->create([
                'name' => $name
            ]);

            $teachers = Teacher::all()->random(2);
            $teachers->each(function ($teacher) use ($grade) {
                $teacher->grades()->create([
                    'grade_id' => $grade->id
                ]);
            });

            // Create additional random students
            User::factory(10)->create(['role' => 'student'])->each(function ($user) use ($grade) {
                $student = Student::factory()->create([
                    'user_id' => $user->id,
                    'grade_id' => $grade->id
                ]);
                $activities = Activity::factory(5)->create();
                $activities->each(function ($activity) use ($student) {
                    $student->activities()->create([
                        'activity_id' => $activity->id
                    ]);
                });
            });
        }
    }
}
