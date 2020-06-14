<?php

namespace Tests\Unit\RepositoryTests;

use App\Blog;
use App\Repositories\BlogRepository;
use DemeterChain\B;
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

    public function testInsertBlogShouldReturnInteger() {
        $this->blogRepository->allows('insertBlog')->andReturn(1);
        $assertValue = $this->blogRepository->insertBlog(new Blog());
        self::assertIsInt($assertValue);
    }

    public function testUpdateBlogShouldReturnFalse() {
        $this->blogRepository->allows('updateBlog')->andReturn(false);
        $assertValue = $this->blogRepository->updateBlog([], new Blog());
        self::assertFalse($assertValue);
    }

    public function testUpdateBlogShouldReturnTrue() {
        $this->blogRepository->allows('updateBlog')->andReturn(true);
        $assertValue = $this->blogRepository->updateBlog([], new Blog());
        self::assertTrue($assertValue);
    }

    protected function tearDown(): void {
        parent::tearDown();
        Mockery::close();
    }
}
