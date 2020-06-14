<?php

namespace Tests\Unit\ModelTests;

use App\Blog;
use Mockery;
use PHPUnit\Framework\TestCase;

class BlogTest extends TestCase {

    protected $blog;

    protected function setUp(): void {
        $this->blog = Mockery::mock(Blog::class)->makePartial();
        $this->blog->title = 'Test blog title!';
        $this->blog->content = 'test content';
        $this->blog->user_id = 1;
    }

    public function testBlogShouldNotBeNull() {
        self::assertNotNull($this->blog);
    }

    public function testBlogShouldBeAValidBlogInstance() {
        self::assertInstanceOf(Blog::class, $this->blog);
    }

    public function testBlogShouldNotHaveWrongTitle() {
        self::assertNotEquals('wrong title', $this->blog->title);
    }

    public function testBlogShouldHaveTheProperTitle() {
        self::assertEquals('Test blog title!', $this->blog->title);
    }

    public function testBlogShouldNotHaveProperContent() {
        self::assertNotEquals('wrong content', $this->blog->content);
    }

    public function testBlogShouldHaveProperContent() {
        self::assertEquals('test content', $this->blog->content);
    }

    public function testBlogShoudNotHaveProperUserId() {
        self::assertNotEquals(2, $this->blog->user_id);
    }

    public function testBlogShouldHaveProperUserId() {
        self::assertEquals(1, $this->blog->user_id);
    }

    public function testBlogSaveFunctionRetunsFalse() {
        $this->blog->shouldReceive('save')->andReturn(false);
        $assertValue = $this->blog->save();
        self::assertFalse($assertValue);
    }

    public function testBlogSaveFunctionRetunsTrue() {
        $this->blog->shouldReceive('save')->andReturn(true);
        $assertValue = $this->blog->save();
        self::assertTrue($assertValue);
    }

    protected function tearDown(): void {
        Mockery::close();
    }
}
