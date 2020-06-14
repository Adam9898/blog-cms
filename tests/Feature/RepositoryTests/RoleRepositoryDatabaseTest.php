<?php

namespace Tests\Feature\RepositoryTests;

use App\Enums\UserRole;
use App\Repositories\RoleRepository;
use App\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleRepositoryDatabaseTest extends TestCase
{

    use RefreshDatabase;

    private static $roleRepository;
    private $databaseData;
    private const TABLE_NAME = 'roles';

    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$roleRepository = resolve(RoleRepository::class);
    }

    protected function setUp(): void {
        parent::setUp();
        $this->databaseData = factory(Role::class, 1)->create();
    }

    public function testRoleRepositoryShouldNotBeNull() {
        self::assertNotNull(self::$roleRepository);
    }

    public function testRoleRepositoryShouldBeOfProperInstance() {
        self::assertInstanceOf(RoleRepository::class, self::$roleRepository);
    }

    public function testGetRoleIdByNameShouldReturnAnInteger() {
        $key = self::$roleRepository->getRoleIdByName(UserRole::Regular);
        self::assertIsInt($key);
    }

    public function testGetRoleIdByNameShouldReturnTheProperKey() {
        $key = self::$roleRepository->getRoleIdByName(UserRole::Regular);
        self::assertEquals(1, $key);
    }

}
