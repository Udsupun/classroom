<?php

namespace Tests\Feature\Actions;

use App\Actions\GetStudentDashboardDetails;
use App\Models\Activity;
use App\Models\Grade;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetStudentDashboardDetailsTest extends TestCase
{
    use RefreshDatabase;

    private $student;

    private $studentUser;

    private $grade;

    protected function setUp(): void
    {
        parent::setUp();

        $this->studentUser = User::factory()->create(['role' => 'student']);
        $activities = Activity::factory(5)->create();
        $this->grade = Grade::factory()->create(['name' => 'Grade 6']);
        $this->student = Student::factory()->create([
            'user_id' => $this->studentUser->id,
            'grade_id' => $this->grade->id,
        ]);
        $this->student->activities()->attach($activities);

        Sanctum::actingAs(
            $this->studentUser
        );
    }

    /**
     * Test Student dashboard details from Action
     */
    public function testStudentDashboardDetailsFromAction()
    {
        $activities = Activity::all();

        $action = new GetStudentDashboardDetails();

        $result = $action->handle();

        $this->assertEquals($this->studentUser, $result);
    }

    /**
     * Test Student dashboard details from HTTP request
     */
    public function testStudentDashboardDetailsFromHttpRequest()
    {
        $headers = [
            'Accept' => 'application/json',
        ];
        $response = $this->withHeaders($headers)->get('/api/dashboard-details');

        $responseData = $response->json();

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJsonStructure([
            'message',
            'data' => [
                'details' => [
                    'name',
                    'email',
                    'address',
                ],
                'student_id',
                'grade' => [
                    'uuid',
                    'name',
                ],
                'activities' => [
                    '*' => [
                        'uuid',
                        'name',
                        'subject',
                        'score',
                    ],
                ],
            ],
        ]);
        $this->assertCount(5, $responseData['data']['activities']);
        $this->assertEquals('Dashboard details', $responseData['message']);
        $this->assertEquals($this->student->uuid, $responseData['data']['student_id']);
        $this->assertEquals($this->grade->name, $responseData['data']['grade']['name']);
        $this->assertEquals($this->studentUser->name, $responseData['data']['details']['name']);
    }
}
