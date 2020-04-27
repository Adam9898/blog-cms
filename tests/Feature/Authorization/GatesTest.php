<?php

namespace Tests\Feature\Validation;

use App\Enums\UserRole;
use App\Role;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Gate;
use RoleSeeder;
use Tests\TestCase;

class GatesTest extends TestCase
{

    use RefreshDatabase;

    protected function setUp(): void {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    public function testRoleGateShouldReturnFalse() {
        $user = factory(User::class)->create();
        $user->roles()->attach(1);
        $this->actingAs($user);
        self::assertFalse(Gate::allows('role', UserRole::Editor));
    }

    public function testRoleGateShouldReturnTrue() {
        $user = factory(User::class)->create();
        $user->roles()->attach(1);
        $this->actingAs($user);
        self::assertTrue(Gate::allows('role', UserRole::Regular));
    }
}
