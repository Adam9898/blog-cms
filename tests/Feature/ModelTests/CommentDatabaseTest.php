<?php

namespace Tests\Feature\ModelTests;

use App\Blog;
use App\Comment;
use App\Role;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentDatabaseTest extends TestCase
{
    use RefreshDatabase;

    private const TABLE_NAME = 'comments';
    protected $databaseData;

    protected function setUp(): void {
        parent::setUp();
        $this->databaseData = factory(Comment::class)->create();
    }

    public function testCommentShouldNotBeInDatabase() {
        $this->databaseData->delete();
        $this->assertDatabaseMissing(self::TABLE_NAME, $this->databaseData->toArray());
    }

    public function testCommentShouldBeInDatabase() {
        $this->assertDatabaseHas(self::TABLE_NAME, $this->databaseData->toArray());
    }

    public function testCommentShouldHaveAnAuthor() {
        self::assertInstanceOf(User::class, $this->databaseData->user);
    }

    public function testCommentShouldBeAPartOfABlog() {
        self::assertInstanceOf(Blog::class, $this->databaseData->blog);
    }
}
