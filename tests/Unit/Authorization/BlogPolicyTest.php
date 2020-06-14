<?php

namespace Tests\Unit\Authorization;

use App\Blog;
use App\Policies\BlogPolicy;
use App\User;
use Mockery;
use PHPUnit\Framework\TestCase;

class BlogPolicyTest extends TestCase {


    private $blogPolicy;

    protected function setUp(): void {
        parent::setUp();
        $this->blogPolicy = Mockery::mock(BlogPolicy::class)->makePartial();
    }

    public function testBlogPolicyShouldNotBeNull() {
        self::assertNotNull($this->blogPolicy);
    }

    public function testBlogPolicyShouldBeOfProperInstance() {
        self::assertInstanceOf(BlogPolicy::class, $this->blogPolicy);
    }

    public function testShowBlogPolicyShouldReturnTrue() {
        self::assertTrue($this->blogPolicy->view(null, new Blog()));
    }

    public function testUpdateShouldReturnFalse() {
        $this->blogPolicy->allows('update')->andReturn(false);
        self::assertFalse($this->blogPolicy->update(new User(), new Blog()));
    }

    public function testUpdateShouldReturnTrue() {
        $this->blogPolicy->allows('update')->andReturn(true);
        self::assertTrue($this->blogPolicy->update(new User(), new Blog()));
    }

    public function testDeleteShouldReturnFalse() {
        $this->blogPolicy->allows('delete')->andReturn(false);
        self::assertFalse($this->blogPolicy->delete(new User(), new Blog()));
    }

    public function testDeleteShouldReturnTrue() {
        $this->blogPolicy->allows('delete')->andReturn(true);
        self::assertTrue($this->blogPolicy->delete(new User(), new Blog()));
    }

    protected function tearDown(): void {
        parent::tearDown();
        Mockery::close();
    }
}
