<?php

namespace Tests\Feature\ModelTests;

use App\Enums\UserRole;
use App\Role;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleDatabaseTest extends TestCase {

    use RefreshDatabase;

    private const TABLE_NAME = 'roles';
    protected $databaseData;

    protected function setUp(): void {
        parent::setUp();
        factory(User::class)->create();
        $this->databaseData = factory(Role::class)->create();
        $this->databaseData->users()->attach(1);
    }

    public function testRoleShouldNotBeInDatabase() {
        $this->databaseData->delete();
        $this->assertDatabaseMissing(self::TABLE_NAME, $this->databaseData->toArray());
    }

    public function testRoleShouldBeInDatabase() {
        $this->assertDatabaseHas(self::TABLE_NAME, $this->databaseData->toArray());
    }

    public function testRoleShouldBeAttachedToUser() {
        self::assertInstanceOf(User::class, $this->databaseData->users->find(1));
    }

    public function testRoleShouldBeAnEnumValueOfRegular() {
        self::assertEquals(UserRole::Regular, Role::find(1)->role_name);
    }
}
