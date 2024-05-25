<?php

namespace Tests\Unit\Actions;

use App\Actions\GetGradeStudents;
use App\Http\Resources\GradeResource;
use App\Http\Resources\StudentResource;
use App\Models\Grade;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class GetGradeStudentsTest extends TestCase
{
    use RefreshDatabase;

    private $grade;

    protected function setUp(): void
    {
        parent::setUp();

        $this->grade = Grade::factory()->create(['name' => 'Grade 6']);
        $gradeId = $this->grade->id;
        User::factory(10)->create(['role' => 'student'])->each(function ($user) {
            Student::factory()->create([
                'user_id' => $user->id,
                'grade_id' => $this->grade->id,
            ]);
        });
    }

    public function testHandleMethodReturnsCorrectData()
    {
        $students = Student::all();

        $action = new GetGradeStudents();

        $result = $action->handle($this->grade);

        $expectedResult = [
            'grade' => GradeResource::make($this->grade),
            'students' => StudentResource::collection($students),
        ];

        $this->assertEquals($expectedResult, $result);
    }

    public function testAsControllerMethodAuthorizesAndReturnsCorrectData()
    {
        $user = User::factory()->create(['role' => 'teacher']);
        Gate::shouldReceive('authorize')->with('is-teacher')->once();

        $response = $this->actingAs($user)
            ->get('/api/grade-students/'.$this->grade->uuid);

        $responseData = $response->json();

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $this->assertCount(10, $responseData['students']);
    }
}
