<?php

namespace Tests\Feature\Actions;

use App\Actions\GetGradeStudents;
use App\Http\Resources\GradeResource;
use App\Http\Resources\StudentResource;
use App\Models\Grade;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
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
        $user = User::factory()->create(['role' => 'teacher']);
        Sanctum::actingAs(
            $user
        );
    }

    /**
     * Test Grade Students from Action
     */
    public function testGradeStudentsFromAction()
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

    /**
     * Test Grade Students from HTTP request
     */
    public function testGradeStudentsFromHttpRequest()
    {
        $headers = [
            'Accept' => 'application/json',
        ];
        $response = $this->withHeaders($headers)->get('/api/grade-students/'.$this->grade->uuid);

        $responseData = $response->json();

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJsonStructure([
            'message',
            'data' => [
                'grade' => [
                    'uuid',
                    'name',
                ],
                'students' => [
                    '*' => [
                        'uuid',
                        'details' => [
                            'name',
                            'email',
                            'address',
                        ],
                    ],
                ],
            ],
        ]);
        $this->assertCount(10, $responseData['data']['students']);
    }
}
