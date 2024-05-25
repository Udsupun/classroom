<?php

namespace Tests\Unit;

use App\Actions\UserLogin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);
    }

    /**
     * Test user login with valid characters
     */
    public function testAUserWithCorrectCredentials()
    {
        $action = new UserLogin();
        $result = $action->handle([
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $this->assertNotNull($result);
        $this->assertEquals($this->user->id, $result->id);
    }

    /**
     * Test user invalid characters
     */
    public function testAUserWithInvalidCredentials()
    {
        $action = new UserLogin();
        $result = $action->handle([
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $this->assertNull($result);
    }

    /**
     * Test http request with valid characters
     */
    public function testUserLogInHttpResponseWithValidCredentials()
    {
        $response = $this->post('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'User logged in successfully',
                'data' => [
                    'user' => [
                        'id' => $this->user->id,
                        'email' => $this->user->email,
                    ],
                ],
            ]);
    }

    /**
     * Test http request with invalid characters
     */
    public function testUserLogInHttpResponseWithInvalidCredentials()
    {
        $response = $this->post('/api/login', [
            'email' => 'test@example.com',
            'password' => 'invalidpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'status' => false,
                'message' => 'User email or password is wrong',
            ]);
    }
}
