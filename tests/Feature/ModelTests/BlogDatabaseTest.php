<?php

namespace Tests\Feature\ModelTests;

use App\Comment;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;
use App\Blog;

class BlogDatabaseTest extends TestCase {

    use RefreshDatabase;

    private const TABLE_NAME = 'blogs';
    protected $databaseData;

    public function setUp(): void {
        parent::setUp();
        // creating the comments before the blog to bypass foreign key constraint
        factory(Comment::class, 6)->create()
            ->each(function ($comment) {
                $comment->blog()->associate(1);
                $comment->save();
            });
        $this->databaseData = factory(Blog::class)->create();
    }

    public function testBlogShouldNotBeInDatabase() {
        $this->databaseData->forceDelete();
        $this->assertDatabaseMissing(self::TABLE_NAME, $this->databaseData->toArray());
    }

    public function testBlogShouldBeInDatabase() {
        $this->assertDatabaseHas(self::TABLE_NAME, $this->databaseData->toArray());
    }

    public function testBlogIsSoftDeleted() {
        $this->databaseData->delete();
        $this->assertSoftDeleted(self::TABLE_NAME, $this->databaseData->toArray());
    }

    public function testBlogShouldHaveAnAuthor() {
        $author = $this->databaseData->user;
        self::assertInstanceOf(User::class, $author);
    }

    public function testBlogShouldHaveComments() {
        $blog = Blog::find(1);
        self::assertInstanceOf(Comment::class, $blog->comments->find(3));
    }
}
