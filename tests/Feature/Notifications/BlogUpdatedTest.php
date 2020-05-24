<?php

namespace Tests\Feature;

use App\Blog;
use App\Notifications\BlogUpdated;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogUpdatedTest extends TestCase {

    use RefreshDatabase;

    private Blog $blog;
    private User $user;

    protected function setUp(): void {
        parent::setUp();
        $this->blog = factory(Blog::class)->create();
        $this->user = factory(User::class)->create();
        $this->user->notify(new BlogUpdated($this->blog));
    }

    public function testUserShouldBeNotified() {
        $notification = $this->user->notifications->get(0);
        $data = $notification->data;
        self::assertEquals($this->blog->user->name, $data['blogAuthor']);
        self::assertEquals($this->blog->title, $data['blogTitle']);
    }

}
