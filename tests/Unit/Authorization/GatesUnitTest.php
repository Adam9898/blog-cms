<?php

namespace Tests\Unit\Authorization;

use App\Enums\UserRole;
use Illuminate\Support\Facades\Gate;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

/**
 * I wrote this test class to try out Facade mocking, as Laravel has this feature built in
 * @author Adam Reichardt
 */
class GatesUnitTest extends TestCase {

    public function testRoleGateShouldReturnFalse() {
        Gate::shouldReceive('allows')->with('role', UserRole::Editor)->andReturn(false);
        self::assertFalse(Gate::allows('role', UserRole::Editor));
    }

    public function testRoleGateShouldReturnTrue() {
        Gate::shouldReceive('allows')->with('role', UserRole::Regular)->andReturn(true);
        self::assertTrue(Gate::allows('role', UserRole::Regular));
    }

}
