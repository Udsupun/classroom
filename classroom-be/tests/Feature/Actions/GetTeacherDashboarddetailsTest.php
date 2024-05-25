<?php

namespace Tests\Feature\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Grade;
use App\Models\Teacher;
use App\Actions\GetTeacherDashboardDetails;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class GetTeacherDashboarddetailsTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    private $teacher;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'teacher']);
        $this->teacher = Teacher::factory()->create([
            'user_id' => $this->user->id,
        ]);
        $names = ['Grade 6', 'Grade 7', 'Grade 8'];
        foreach ($names as $name) {
            $grade = Grade::factory()->create([
                'name' => $name,
            ]);
            $grade->teachers()->attach($this->teacher);
        }
        Sanctum::actingAs(
            $this->user
        );
    }

    /**
     * Test Teacher dashboard details from Action
     */
    public function testTeacherDashboardDetailsFromAction()
    {
        $activities = Grade::all();

        $action = new GetTeacherDashboardDetails();

        $result = $action->handle();

        $this->assertEquals($this->user, $result);
    }

    /**
     * Test Teacher dashboard details from HTTP request
     */
    public function testTeacherDashboardDetailsFromHttpRequest()
    {
        $headers = [
            'Accept' => 'application/json',
        ];
        $response = $this->withHeaders($headers)->get('/api/teacher-classes');

        $responseData = $response->json();

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJsonStructure([
            'message',
            'data' => [
                '*' => [
                    'uuid',
                    'name',
                ],
            ],
        ]);
        $this->assertCount(3, $responseData['data']);
        $this->assertEquals('Dashboard details', $responseData['message']);
    }
}
