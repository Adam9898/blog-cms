<?php

namespace Tests\Unit\ControllerTests;

use App\Http\Controllers\Auth\RegisterController;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class RegisterControllerTest extends TestCase {

    private static $registerController;

    protected function setUp(): void {
        parent::setUp();
        // inserting mock repositories into the service container
        $this->mock(RoleRepository::class, function ($roleRepository) {
            $roleRepository->allows('createNewUser');
        });
        $this->mock(UserRepository::class, function ($userRepository) {
            $userRepository->allows('getRoleIdByName')->andReturn(1);
        });
    }

    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$registerController = resolve(RegisterController::class);
    }

    public function testRegisterControllerShouldNotBeNull() {
        self::assertNotNull(self::$registerController);
    }

    public function testRegisterControllerShouldBeOfProperInstance() {
        self::assertInstanceOf(RegisterController::class, self::$registerController);
    }

    public function testUniqueEmailValidatorShouldReturnStatusCode200() {
        $this->mock(UserRepository::class, function ($userRepository) {
            $userRepository->allows('findUserByEmail')->andReturn(new User());
        });
        $response = $this->get('/api/unique-email/test@test.com');
        $response->assertOk();
    }

    public function testUniqueEmailValidatorShouldReturnAJsonResponse() {
        $this->mock(UserRepository::class, function ($userRepository) {
            $userRepository->allows('findUserByEmail')->andReturn(new User());
        });
        $response = $this->get('/api/unique-email/test@test.com');
        $response->assertJsonStructure(['email', 'valid']);
    }

    public function testUniqueEmailValidatorShouldReturnExactJson() {
        $this->mock(UserRepository::class, function ($userRepository) {
            $userRepository->allows('findUserByEmail')->andReturn(null);
        });
        $response = $this->get('/api/unique-email/test@test.com');
        $response->assertExactJson(['email' => 'test@test.com', 'valid' => true]);
    }


}
