<?php

namespace Tests\Unit\ModelTests;

use App\Comment;
use Mockery;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase {
    protected $comment;

    protected function setUp(): void {
        $this->comment = Mockery::mock(Comment::class)->makePartial();
        $this->comment->blog_id = 1;
        $this->comment->user_id = 1;
        $this->comment->content = 'test content';
    }

    public function testCommentShouldNotBeNull() {
        self::assertNotNull($this->comment);
    }

    public function testCommentShouldHaveAValidInstance() {
        self::assertInstanceOf(Comment::class, $this->comment);
    }

    public function testCommentShouldNotHaveWrongBlogId() {
        self::assertNotEquals(2, $this->comment->blog_id);
    }

    public function testCommentShouldHaveProperBlogId() {
        self::assertEquals(1, $this->comment->blog_id);
    }

    public function testCommentShouldNotHaveWrongUserId() {
        self::assertNotEquals(2, $this->comment->user_id);
    }

    public function testCommentShouldHaveProperUserId() {
        self::assertEquals(1, $this->comment->user_id);
    }

    public function testCommentShouldNotHaveWrongContent() {
        self::assertNotEquals('wrong content', $this->comment->content);
    }

    public function testCommentShouldHaveProperContent() {
        self::assertEquals('test content', $this->comment->content);
    }

    public function testCommentSaveFunctionReturnsFalse() {
        $this->comment->shouldReceive('save')->andReturn(false);
        $assertValue = $this->comment->save();
        self::assertFalse($assertValue);
    }

    public function testCommentSaveFunctionReturnsTrue() {
        $this->comment->shouldReceive('save')->andReturn(true);
        $assertValue = $this->comment->save();
        self::assertTrue($assertValue);
    }

    protected function tearDown(): void {
        Mockery::close();
    }
}
