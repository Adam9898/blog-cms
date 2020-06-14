<?php

namespace Tests\Unit\ModelTests;

use App\Enums\UserRole;
use App\Role;
use Mockery;
use PHPUnit\Framework\TestCase;

class RoleTest extends TestCase {

    protected $role;

    protected function setUp(): void {
        $this->role = Mockery::mock(Role::class)->makePartial();
        $this->role->role_name = UserRole::Regular;
    }

    public function testRoleShouldNotBeNull() {
        self::assertNotNull($this->role);
    }

    public function testRoleShouldHaveValidInstance() {
        self::assertInstanceOf(Role::class, $this->role);
    }

    public function testRoleShouldNotHaveWrongRoleName() {
        self::assertNotEquals(UserRole::Admin, $this->role->role_name);
    }

    public function testRoleSaveFunctionShouldReturnFalse() {
        $this->role->shouldReceive('save')->andReturn(false);
        $assertValue = $this->role->save();
        self::assertFalse($assertValue);
    }

    public function testRoleSaveFunctionShouldReturnTrue() {
        $this->role->shouldReceive('save')->andReturn(true);
        $assertValue = $this->role->save();
        self::assertTrue($assertValue);
    }

    protected function tearDown(): void {
        Mockery::close();
    }
}
