<?php

namespace Tests\Feature\ControllerTests;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use RoleSeeder;
use Tests\TestCase;

class RegisterControllerTest extends TestCase {

    use RefreshDatabase;

    private $data;

    protected function setUp(): void {
        parent::setUp();
        $this->seed(RoleSeeder::class);
        $this->data = [
            'name' => 'testuser',
            'email' => 'test@test.com',
            'password' => 'Test0123456',
            'password_confirmation' => 'Test0123456'
        ];
    }

    public function testRegisterRouteShouldRespondWith200() {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function testRegistrationRedirectsToHomePage() {
        $response = $this->post('/register', $this->data);
        $response->assertRedirect('/home');
    }

    public function testInvalidDataShouldNotBeRegisteredInsteadItShouldRedirectToMainPage() {
        $this->data['password_confirmation'] = 'wrong';
        $response = $this->post('/register', $this->data);
        $response->assertRedirect('/');
    }

    public function testAuthenticatedUserShouldBeRedirectedToHomePage() {
        $user = factory(User::class)->create();
        $respone = $this->actingAs($user)->get('/register');
        $respone->assertRedirect('/home');
    }
}
