<?php

namespace Tests\Feature\Authorization;

use App\Blog;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogPolicyTest extends TestCase {

    use RefreshDatabase;

    private $blog;

    protected function setUp(): void {
        parent::setUp();
        $this->blog = factory(Blog::class)->create();
    }

    public function testUpdateShouldReturnFalse() {
        $blog = factory(Blog::class)->create();
        self::assertFalse($this->blog->user->can('update', $blog));
    }

    public function testUpdateShouldReturnTrue() {
        self::assertTrue($this->blog->user->can('update', $this->blog));
    }

    public function testDeleteShouldReturnFalse() {
        $blog = factory(Blog::class)->create();
        self::assertFalse($this->blog->user->can('delete', $blog));
    }

    public function testDeleteShouldReturnTrue() {
        self::assertTrue($this->blog->user->can('delete', $this->blog));
    }

}
