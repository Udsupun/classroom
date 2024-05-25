<?php

namespace Tests\Feature;

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

    private $user;

    private $teacherUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->teacherUser = User::factory()->create(['role' => 'teacher']);
        $this->user = User::factory()->create(['role' => 'student']);
        $activities = Activity::factory(5)->create();
        $grade = Grade::factory()->create(['name' => 'Grade 6']);
        $teacher = Teacher::factory()->create([
            'user_id' => $this->teacherUser->id
        ]);
        $this->student = Student::factory()->create([
            'user_id' => $this->user->id,
            'grade_id' => $grade->id,
        ]);
        $this->student->activities()->attach($activities);
        $teacher->grades()->attach($grade);

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

        $result = $action->handle($this->student);

        $expectedResult = StudentActivityResource::make($this->student);

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * Test Student Activities from HTTP request
     */
    public function testStudentActivitiesFromHttpRequest()
    {
        $response = $this->get('/api/student-activities/' . $this->student->uuid);

        $responseData = $response->json();

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $this->assertCount(5, $responseData['data']['activities']);
    }
}
