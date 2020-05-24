<?php

namespace Tests\Unit\Notifications;

use App\Blog;
use App\Notifications\BlogCreated;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class BlogCreatedTest extends TestCase {

    use RefreshDatabase;

    private BlogCreated $blogCreated;
    private $blog;

    protected function setUp(): void{
        parent::setUp();
        $this->blog =  factory(Blog::class)->make();
        $this->blogCreated = new BlogCreated($this->blog);
    }

    public function testBlogCreatedShouldNotBeNull() {
        self::assertNotNull($this->blogCreated);
    }

    public function testBlogCreatedShouldBeAnInstanceOfBlogCreated() {
        self::assertInstanceOf(BlogCreated::class, $this->blogCreated);
    }

    public function testViaShouldReturnAnArray() {
        $array = $this->blogCreated->via(new User());
        self::assertIsArray($array);
    }

    public function testToArrayShouldReturnAnArray() {
        $array = $this->blogCreated->toArray(new User());
        self::assertIsArray($array);
    }

    public function testToArrayShouldReturnArrayWithProperKeys() {
        $array = $this->blogCreated->toArray(new User());
        self::assertArrayHasKey('blogAuthor', $array);
        self::assertArrayHasKey('blogTitle', $array);
    }

    public function testToArrayReturnValueShouldContainerProperData() {
        $array = $this->blogCreated->toArray(new User());
        self::assertEquals($this->blog->user->name, $array['blogAuthor']);
        self::assertEquals($this->blog->title, $array['blogTitle']);
    }

    public function testViaShouldReturnArrayWithProperItems() {
        $array = $this->blogCreated->via(new User());
        self::assertContains('database', $array);
        self::assertContains('broadcast', $array);
    }

    public function testBlogCreatedNotificationWasDispatchedToUser() {
        $user = factory(User::class)->make();
        Notification::fake();
        Notification::assertNothingSent();
        $user->notify(new BlogCreated($this->blog));
        Notification::assertSentTo([$user], BlogCreated::class);
    }

}
