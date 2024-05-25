<?php

namespace Tests\Feature\Actions;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Activity;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Teacher;
use App\Actions\GetStudentActivities;
use App\Http\Resources\StudentActivityResource;
use Laravel\Sanctum\Sanctum;

class GetStudentActivitiesTest extends TestCase
{
    use RefreshDatabase;

    private $student;

    private $studentUser;

    private $teacherUser;

    private $grade;

    protected function setUp(): void
    {
        parent::setUp();

        $this->teacherUser = User::factory()->create(['role' => 'teacher']);
        $this->studentUser = User::factory()->create(['role' => 'student']);
        $activities = Activity::factory(5)->create();
        $this->grade = Grade::factory()->create(['name' => 'Grade 6']);
        $teacher = Teacher::factory()->create([
            'user_id' => $this->teacherUser->id
        ]);
        $this->student = Student::factory()->create([
            'user_id' => $this->studentUser->id,
            'grade_id' => $this->grade->id,
        ]);
        $this->student->activities()->attach($activities);
        $teacher->grades()->attach($this->grade);

        Sanctum::actingAs(
            $this->teacherUser
        );
    }

    /**
     * Test Student Activities from Action
     */
    public function testStudentsActivitiesFromAction()
    {
        $activities = Activity::all();

        $action = new GetStudentActivities();

        $result = $action->asController($this->student);


        $this->assertEquals($this->student, $result);
    }

    /**
     * Test Student Activities from HTTP request
     */
    public function testStudentActivitiesFromHttpRequest()
    {
        $headers = [
            'Accept' => 'application/json',
        ];
        $response = $this->withHeaders($headers)->get('/api/student-activities/' . $this->student->uuid);

        $responseData = $response->json();

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $this->assertCount(5, $responseData['data']['activities']);
        $response->assertJsonStructure([
            'message',
            'data' => [
                'details' => [
                    'name',
                    'email',
                    'address'
                ],
                'student_id',
                'grade' => [
                    'uuid',
                    'name'
                ],
                'activities' => [
                    '*' => [
                        'uuid',
                        'name',
                        'subject',
                        'score'
                    ],
                ]
            ],
        ]);
        $this->assertEquals($this->student->uuid, $responseData['data']['student_id']);
        $this->assertEquals($this->grade->name, $responseData['data']['grade']['name']);
        $this->assertEquals($this->studentUser->name, $responseData['data']['details']['name']);
    }
}
