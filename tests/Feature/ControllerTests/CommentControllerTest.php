<?php

namespace Tests\Feature\ControllerTests;

use App\Blog;
use App\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use RoleSeeder;
use Tests\TestCase;

class CommentControllerTest extends TestCase {

    use RefreshDatabase;

    private const TABLE_NAME = 'comments';
    private $commentArr;

    protected function setUp(): void {
        parent::setUp();
        $this->seed(RoleSeeder::class);
        $comment = factory(Comment::class)->create();
        $this->commentArr = $comment->toArray();
        $comment->user->roles()->attach(1);
        $this->actingAs($comment->user);
    }

    public function testStoreShouldRedirectToProperBlog() {
        $postData = [
            'content' => 'This is a test comment.',
            'blog' => 1
        ];
        $response = $this->post('/comments', $postData);
        $response->assertRedirect('/blogs/1');
    }

    public function testStoreShouldInsertCommentToDatabase() {
        $postData = [
            'content' => 'This is a test comment.',
            'blog' => 1
        ];
        $this->post('/comments', $postData);
        $dbAssertData = [
            'content' =>  'This is a test comment.',
            'blog_id' => 1
        ];
        $this->assertDatabaseHas(self::TABLE_NAME, $dbAssertData);
    }

    public function testDeleteShouldRedirectToProperBlog() {
        $response = $this->delete('/comments/1');
        $response->assertRedirect('/blogs/1');
    }

    public function testDeleteShouldRemoveCommentFromDatabase() {
        $this->delete('/comments/1');
        $this->assertDatabaseMissing(self::TABLE_NAME, $this->commentArr);
    }

}
