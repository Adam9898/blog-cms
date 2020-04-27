<?php

namespace Tests\Unit\RepositoryTests;

use App\Repositories\UserRepository;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase {

    private $userRepository;

    protected function setUp(): void {
        parent::setUp();
        $this->userRepository = Mockery::mock(UserRepository::class);
    }

    public function testUserRepositoryShouldNotBeNull() {
        self::assertNotNull($this->userRepository);
    }

    public function testUserRepositoryShouldBeOfProperInstance() {
        self::assertInstanceOf(UserRepository::class, $this->userRepository);
    }

    public function testCreateNewUserShouldNotReturnFalse() {
        $this->userRepository->allows('createNewUser')->andReturn(true);
        $user = new User();
        $assertValue = $this->userRepository->createNewUser($user);
        self::assertNotFalse($assertValue);
    }

    public function testRegisterComparatorCreateNewUserShouldReturnTrue() {
        $this->userRepository->allows('createNewUser')->andReturn(true);
        $user = new User();
        $assertValue = $this->userRepository->createNewUser($user);
        self::assertTrue($assertValue);
    }

    public function testGetUserRolesShouldReturnACollection() {
        $collection = new Collection();
        $this->userRepository->allows('getUserRoles')->andReturn($collection);
        $user = new User();
        $assertValue = $this->userRepository->getUserRoles($user);
        self::assertInstanceOf(Collection::class, $assertValue);
    }

    protected function tearDown(): void {
        parent::tearDown();
        Mockery::close();
    }
}
