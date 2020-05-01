<?php

namespace Tests\Feature\RepositoryTests;

use App\Comment;
use App\Repositories\CommentRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentRepositoryDatabaseTest extends TestCase {

    use RefreshDatabase;

    private static $commentRepository;
    private const TABLE_NAME = 'comments';
    private $comment;

    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$commentRepository = resolve(CommentRepository::class);
    }

    protected function setUp(): void {
        parent::setUp();
        $this->comment = factory(Comment::class)->create();
    }

    public function testCommentRepositoryShouldNotBeNull() {
        self::assertNotNull(self::$commentRepository);
    }

    public function testCommentRepositoryShouldBeOfProperInstance() {
        self::assertInstanceOf(CommentRepository::class, self::$commentRepository);
    }

    public function testInsertCommentShouldInsertTheCommentToDatabase() {
        $newComment = factory(Comment::class)->make([
            'user_id' => 1,
            'blog_id' => 1
        ]);
        $commentArr = $newComment->toArray();
        self::$commentRepository->insertComment($newComment);
        $this->assertDatabaseHas(self::TABLE_NAME, $commentArr);
    }

    public function testDeleteCommentShouldDeleteTheCommentFromDatabase() {
        $commentArr = $this->comment->toArray();
        self::$commentRepository->deleteComment($this->comment);
        $this->assertDatabaseMissing(self::TABLE_NAME, $commentArr);
    }

}
