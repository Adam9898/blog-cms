<?php

namespace Tests\Feature\ModelTests;

use App\Blog;
use App\Role;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserDatabaseTest extends TestCase
{
    use RefreshDatabase;

    private const TABLE_NAME = 'users';
    protected $databaseData;

    protected function setUp(): void {
        parent::setUp();
        factory(Role::class)->create();
        factory(Blog::class, 4)->create()
        ->each(function ($blog) {
            $blog->user()->associate(1);
            $blog->save();
        });
        $this->databaseData = factory(User::class)->create();
    }

    public function testUserShouldNotBeInDatabase() {
        $this->databaseData->delete();
        $this->assertDatabaseMissing(self::TABLE_NAME, $this->databaseData->toArray());
    }

    public function testUserShouldBeInDatabase() {
        $this->assertDatabaseHas(self::TABLE_NAME, $this->databaseData->toArray());
    }

    public function testUserHasAccessToBlogs() {
        $author = User::find(1);
        self::assertInstanceOf(Blog::class, $author->blogs->find(2));
    }

    public function testUserHasAccessToItsRoles() {
        // inserting a new row to the pivot table role_user
        $this->databaseData->roles()->attach(1);
        self::assertInstanceOf(Role::class, $this->databaseData->roles->find(1));
    }
}
