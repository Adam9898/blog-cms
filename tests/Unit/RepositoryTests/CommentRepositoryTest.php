<?php

namespace Tests\Unit\RepositoryTests;

use App\Repositories\CommentRepository;
use Mockery;
use Mockery\Mock;
use PHPUnit\Framework\TestCase;

class CommentRepositoryTest extends TestCase {

    private $commentRepository;

    protected function setUp(): void {
        parent::setUp();
        $this->commentRepository = Mockery::mock(CommentRepository::class);
    }

    public function testCommentRepositoryShouldNotBeNull() {
        self::assertNotNull($this->commentRepository);
    }

    public function testCommentRepositoryShouldBeOfProperInstance() {
        self::assertInstanceOf(CommentRepository::class, $this->commentRepository);
    }

    protected function tearDown(): void {
        parent::tearDown();
        Mockery::close();
    }

}
