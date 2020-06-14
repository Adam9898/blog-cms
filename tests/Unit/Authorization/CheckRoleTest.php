<?php

namespace Tests\Unit\Authorization;

use App\Enums\UserRole;
use App\Http\Middleware\CheckRole;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Mockery;
use Symfony\Component\HttpFoundation\Request;
use Tests\TestCase;
use function foo\func;

class CheckRoleTest extends TestCase {

    private static $checkRole;

    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$checkRole = resolve(CheckRole::class);
    }

    public function testHandleShouldThrowAnException() {
        Gate::shouldReceive('authorize')->andThrow(new AuthorizationException());
        $this->expectException(AuthorizationException::class);
        self::$checkRole->handle(new Request(), function(){}, UserRole::Regular);
    }

    public function testHandleShouldReturnTrue() {
        $callback = function () { return true; };
        Gate::shouldReceive('authorize')->andReturn($callback);
        $assertValue = self::$checkRole->handle(new Request(), $callback, UserRole::Regular);
        self::assertTrue($assertValue);
    }

    protected function tearDown(): void {
        parent::tearDown();
        Mockery::close();
    }

}
