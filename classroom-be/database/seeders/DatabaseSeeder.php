<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Student;
use App\Models\Grade;
use App\Models\Teacher;

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

        // Create teachers with specific names
        $teachers = [
            ['first_name' => 'Diego','last_name' => 'Ven', 'email' => 'ven@organization.com', 'subject' => 'Mathematics'],
            ['first_name' => 'Desmond','last_name' => 'Oster', 'email' => 'desmond@organization.com', 'subject' => 'Science'],
        ];

        foreach ($teachers as $teacher) {
            $user = User::factory()->create([
                'first_name' => $teacher['first_name'],
                'last_name' => $teacher['last_name'],
                'email' => $teacher['email'],
                'role' => 'teacher',
            ]);

            Teacher::factory()->create([
                'user_id' => $user->id,
                'subject' => $teacher['subject']
            ]);
        }

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

            // Create additional random students
            User::factory(10)->create(['role' => 'student'])->each(function ($user) use ($grade) {
                Student::factory()->create(['user_id' => $user->id, 'grade_id' => $grade->id]);
            });
        }

        // Create students with specific names
        // $students = [
        //     ['first_name' => 'Andy','last_name' => 'Beth', 'email' => 'andy@organization.com'],
        // ];

        // $user = User::factory()->create([
        //     'first_name' => 'Andy',
        //     'last_name' => 'Beth',
        //     'email' => 'andy@organization.com',
        //     'role' => 'student',
        // ]);
    }
}
