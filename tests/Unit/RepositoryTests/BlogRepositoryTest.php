<?php

namespace Tests\Unit\RepositoryTests;

use App\Blog;
use App\Repositories\BlogRepository;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use PHPUnit\Framework\TestCase;

class BlogRepositoryTest extends TestCase {

    private $blogRepository;

    protected function setUp(): void {
        parent::setUp();
        $this->blogRepository = Mockery::mock(BlogRepository::class);
    }

    public function testBlogRepositoryShouldNotBeNull() {
        self::assertNotNull($this->blogRepository);
    }

    public function testBlogRepositoryShouldBeOfProperInstance() {
        self::assertInstanceOf(BlogRepository::class, $this->blogRepository);
    }

    public function testGetSpecificBlogShouldReturnABlog() {
        $this->blogRepository->allows('getSpecificBlog')->andReturn(new Blog());
        $blog = $this->blogRepository->getSpecificBlog(1);
        self::assertInstanceOf(Blog::class, $blog);
    }

    public function testGetBlogsAndLimitShouldReturnALaravelCollection() {
        $blogCollection = new Collection();
        $this->blogRepository->allows('getBlogsAndLimit')->andReturn($blogCollection);
        self::assertInstanceOf(Collection::class, $blogCollection);
    }

    protected function tearDown(): void {
        parent::tearDown();
        Mockery::close();
    }
}
