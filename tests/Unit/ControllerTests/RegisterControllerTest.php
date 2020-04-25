<?php

namespace Tests\Unit\ControllerTests;

use App\Http\Controllers\Auth\RegisterController;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
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


}
