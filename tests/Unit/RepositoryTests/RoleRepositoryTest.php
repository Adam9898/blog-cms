<?php

namespace Tests\Unit\RepositoryTests;

use App\Enums\UserRole;
use App\Repositories\RoleRepository;
use Mockery;
use PHPUnit\Framework\TestCase;

class RoleRepositoryTest extends TestCase {

    private $roleRepository;

    protected function setUp(): void {
        parent::setUp();
        $this->roleRepository = Mockery::mock(RoleRepository::class);
    }

    public function testRoleRepositoryShouldNotBeNull() {
        self::assertNotNull($this->roleRepository);
    }

    public function testRoleRepositoryShouldBeOfProperInstance() {
        self::assertInstanceOf(RoleRepository::class, $this->roleRepository);
    }

    public function testGetRoleIdByNameShouldReturnAKey() {
        $this->roleRepository->allows('getRoleIdByName')->andReturn(1);
        $key = $this->roleRepository->getRoleIdByName(UserRole::Regular);
        self::assertIsInt($key);
    }

    protected function tearDown(): void {
        parent::tearDown();
        Mockery::close();
    }

}
