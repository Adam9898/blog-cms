<?php

namespace Tests\Feature\Authorization;

use App\Blog;
use App\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class CommentPolicyTest extends TestCase {

    use RefreshDatabase;

    private $comment;

    protected function setUp(): void {
        parent::setUp();
        $this->comment = factory(Comment::class)->create();
    }

    public function testDeleteShouldReturnFalse() {
        $newComment = factory(Comment::class)->create();
        self::assertFalse($this->comment->user->can('delete', $newComment));
    }

    public function testDeleteShouldReturnTrue() {
        self::assertTrue($this->comment->user->can('delete', $this->comment));
    }

    public function testCreateShouldReturnTrue() {
        $newComment = factory(Comment::class)->make([
            'blog_id' => 1,
            'user_id' => 1
        ]);
        self::assertTrue($this->comment->user->can('create', $newComment));
    }

    public function testCreateShouldReturnFalse() {
        $newComment = factory(Comment::class)->make();
        $blog = new Blog();
        $blog->id = 22;
        $newComment->blog = $blog;
        self::assertFalse($this->comment->user->can('create', $newComment));
    }

}
