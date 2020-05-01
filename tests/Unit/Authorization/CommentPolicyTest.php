<?php

namespace Tests\Unit\Authorization;

use App\Blog;
use App\Comment;
use App\Policies\CommentPolicy;
use App\Repositories\BlogRepository;
use App\User;
use Mockery;
use Tests\TestCase;

class CommentPolicyTest extends TestCase {

    private $commentPolicy;

    protected function setUp(): void {
        parent::setUp();
        $this->commentPolicy = Mockery::mock(CommentPolicy::class);
    }

    public function testCommentPolicyShouldNotBeNull() {
        self::assertNotNull($this->commentPolicy);
    }

    public function testCommentPolicyShouldBeOfProperInstance() {
        self::assertInstanceOf(CommentPolicy::class, $this->commentPolicy);
    }

    public function testCreateShouldReturnFalse() {
        $this->commentPolicy->allows('create')->andReturn(false);
        self::assertFalse($this->commentPolicy->create(new User(), new Comment()));
    }

    public function testCreateShouldReturnTrue() {
        $this->commentPolicy->allows('create')->andReturn(true);
        self::assertTrue($this->commentPolicy->create(new User(), new Comment()));
    }

    public function testDeleteShouldReturnTrue() {
        $this->commentPolicy->allows('delete')->andReturn(true);
        $assertValue = $this->commentPolicy->delete(new User(), new Comment());
        self::assertTrue($assertValue);
    }

    public function testDeleteShouldReturnFalse() {
        $this->commentPolicy->allows('delete')->andReturn(false);
        $assertValue = $this->commentPolicy->delete(new User(), new Comment());
        self::assertFalse($assertValue);
    }

    protected function tearDown(): void {
        parent::tearDown();
        Mockery::close();
    }

}
