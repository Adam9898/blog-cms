<?php

namespace Tests\Feature\Authorization;

use App\Enums\UserRole;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class CheckRoleTest extends TestCase {

    use RefreshDatabase;

    private $user;

    protected function setUp(): void {
        parent::setUp();
        $this->seed(\RoleSeeder::class);
        $user = factory(User::class)->create();
        $user->roles()->attach(1);
        $this->user = $user;
    }

    public function testCheckRoleShouldBeRegistered() {
        Route::get('/test', function (){ return 'test'; })->middleware('role:' . UserRole::Regular);
        try {
            $response = $this->get('/test');
        } catch (BindingResolutionException $exception) {
           $this->fail('CheckRole middleware is not registered');
        }
        $response->assertForbidden(); //middleware is registered but no valid user session
    }

    public function testCheckRoleShouldBlockRequest() {
        $this->actingAs($this->user); // the user has regular role only, therefore the test should fail
        Route::get('/test', function (){})->middleware('role:' . UserRole::Editor);
        $response = $this->get('/test');
        $response->assertForbidden();
    }

    public function testCheckRoleShouldPassRequest() {
        $this->actingAs($this->user);
        Route::get('/test', function (){})->middleware('role:' . UserRole::Regular);
        $response = $this->get('/test');
        $response->assertSuccessful();
    }

}
