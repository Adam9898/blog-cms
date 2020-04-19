<?php

namespace Tests\Feature\RepositoryTests;

use App\Blog;
use App\Repositories\BlogRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use stdClass;
use Tests\TestCase;

class BlogRepositoryDatabaseTest extends TestCase {

    use RefreshDatabase;

    private static $blogRepository;
    private $databaseData;
    private const TABLE_NAME = 'blogs';

    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$blogRepository = resolve(BlogRepository::class);
    }

    protected function setUp(): void {
        parent::setUp();
        $this->databaseData = factory(Blog::class, 4)->create();
    }

    public function testBlogRepositoryShouldNotBeNull() {
        self::assertNotNull(self::$blogRepository);
    }

    public function testBlogRepositoryShouldBeOfProperInstance() {
        self::assertInstanceOf(BlogRepository::class, self::$blogRepository);
    }

    public function testGetSpecificBlogReturnValueShouldNotBeNull() {
        $assertValue = self::$blogRepository->getSpecificBlog(1);
        self::assertNotNull($assertValue);
    }

    public function testGetSpecificBlogShouldReturnABlog() {
        $assertBlog = self::$blogRepository->getSpecificBlog(2);
        self::assertInstanceOf(Blog::class, $assertBlog);
    }

    public function testGetSpecificBlogShouldNotReturnTheProperBlog() {
        $assertBlog = self::$blogRepository->getSpecificBlog(3);
        $originalBlog = $this->databaseData->find(2)->content;
        self::assertNotEquals($originalBlog, $assertBlog);
    }

    public function testGetSpecificBlogShouldReturnTheProperBlog() {
        $assertBlog = self::$blogRepository->getSpecificBlog(2);
        // should be the blog with id 2
        $originalBlogContent = $this->databaseData->find(2)->content;
        self::assertEquals($originalBlogContent, $assertBlog->content);
    }

    public function testDeleteSpecificBlogShouldNotDeleteTheWrongBlog() {
        self::$blogRepository->deleteSpecificBlog(1);
        self::assertNotNull(Blog::find(2));
    }

    public function testDeleteSpecificBlogShouldDeleteABlog() {
        self::$blogRepository->deleteSpecificBlog(1);
        $suspectedDeletedBlog = $this->databaseData->find(1)->toArray();
        $this->assertSoftDeleted(self::TABLE_NAME, $suspectedDeletedBlog);
    }

    public function testGetBlogsAndLimitReturnValueShouldNotBeNull() {
        self::assertNotNull(self::$blogRepository->getBlogsAndLimit(1));
    }

    public function testGetBlogsAndLimitReturnValueShouldReturnAnArray() {
        $assertValue = self::$blogRepository->getBlogsAndLimit(2);
        self::assertTrue(is_array($assertValue));
    }

    public function testGetBlogsAndLimitShouldReturnsABlogWithSameValueAsOriginal() {
        $newestBlog = self::$blogRepository->getBlogsAndLimit(1);
        $originalBlog = $this->databaseData->find(1);
        self::assertEquals($originalBlog->content, $newestBlog[0]->content);
    }

    public function testGetBlogsAndLimitShouldReturn2Blog() {
        $assertBlogs = self::$blogRepository->getBlogsAndLimit(2);
        self::assertEquals(2, sizeof($assertBlogs));
    }

    public function testGetBlogsAndLimitShouldReturn2BlogWithSameContentAsOriginal() {
        $originalBlogs = $this->databaseData->only([1, 2]);
        $assertBlogs = self::$blogRepository->getBlogsAndLimit(2);
        self::assertEquals($originalBlogs->find(1)->content, $assertBlogs[0]->content);
        self::assertEquals($originalBlogs->find(2)->content, $assertBlogs[1]->content);
    }

    public function testGetBlogsAndLimitShouldReturnAll() {
        // when limit is set to max or higher
        self::assertEquals(4, sizeof(self::$blogRepository->getBlogsAndLimit(4)));
        self::assertEquals(4, sizeof(self::$blogRepository->getBlogsAndLimit(6)));
    }

    public function testGetBlogsAndLimitShouldReturnNull() {
        //when limit is zero
        self::assertNull(self::$blogRepository->getBlogsAndLimit(0));
    }

    public function testInsertBlogInsertTheProperBlog() {
        $blog = factory(Blog::class)->make();
        self::$blogRepository->insertBlog($blog);
        $blogRetunedFromDatabase = Blog::find($blog->id);
        self::assertEquals($blog->content, $blogRetunedFromDatabase->content);
    }
}
