<?php

namespace Tests\Feature;

use Tests\TestCase;

class GetStudentActivitiesTest extends TestCase
{
    private $student;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        // $this->user = User::factory(10)->create(['role' => 'student']);
        // $this->student = Grade::factory()->create(['name' => 'Grade 6']);
        // $gradeId = $this->grade->id;
        // User::factory(10)->create(['role' => 'student'])->each(function ($user) {
        //     Student::factory()->create([
        //         'user_id' => $user->id,
        //         'grade_id' => $this->grade->id,
        //     ]);
        // });
    }

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
