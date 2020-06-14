<?php

namespace Tests\Unit\Notifications;

use App\Blog;
use App\Notifications\BlogUpdated;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class BlogUpdatedTest extends TestCase {

    use RefreshDatabase;

    private BlogUpdated $blogUpdated;
    private Blog $blog;

    protected function setUp(): void {
        parent::setUp();
        $this->blog = factory(Blog::class)->make();
        $this->blogUpdated = new BlogUpdated($this->blog);
    }

    public function testBlogUpdatedShouldNotBeNull() {
        self::assertNotNull($this->blogUpdated);
    }

    public function testBlogUpdatedShouldBeAnInstanceOfBlogUpdated() {
        self::assertInstanceOf(BlogUpdated::class, $this->blogUpdated);
    }

    public function testViaShouldReturnAnArray() {
        $array = $this->blogUpdated->via(new User());
        self::assertIsArray($array);
    }

    public function testViaReturnValueShouldContainTheProperElements() {
        $array = $this->blogUpdated->via(new User());
        self::assertContains('database', $array);
        self::assertContains('broadcast', $array);
    }

    public function testToArrayShouldReturnAnArray() {
        $array = $this->blogUpdated->toArray(new User());
        self::assertIsArray($array);
    }

    public function testToArrayReturnValueShouldContainProperKeys() {
        $array = $this->blogUpdated->toArray(new User());
        self::assertArrayHasKey('blogAuthor', $array);
        self::assertArrayHasKey('blogTitle', $array);
        self::assertArrayHasKey('url', $array);
    }

    public function testToArrayReturnValueShouldContainProperElements() {
        $array = $this->blogUpdated->toArray(new User());
        self::assertEquals($this->blog->title, $array['blogTitle']);
        self::assertEquals($this->blog->user->name, $array['blogAuthor']);
        self::assertEquals('/blogs/' . $this->blog->id, $array['url']);
    }

    public function testBlogCreatedNotificationWasDispatchedToUser() {
        $user = factory(User::class)->make();
        Notification::fake();
        Notification::assertNothingSent();
        $user->notify(new BlogUpdated($this->blog));
        Notification::assertSentTo([$user], BlogUpdated::class);
    }

}
