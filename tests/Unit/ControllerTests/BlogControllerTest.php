<?php

namespace Tests\Unit\ControllerTests;

use App\Blog;
use App\Enums\UserRole;
use App\Http\Controllers\BlogController;
use App\Repositories\BlogRepository;
use App\Repositories\UserRepository;
use App\User;
use http\Env\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class BlogControllerTest extends TestCase {


    private static $blogController;

    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$blogController = resolve(BlogController::class);
    }

    protected function setUp(): void {
        parent::setUp();
        $this->withoutMiddleware();
    }

    public function testBlogControllerHasProperMiddleware() {
        $middleware = self::$blogController->getMiddleware();
        $roleMiddleware = $middleware[0]['middleware'];
        self::assertEquals('role:' . UserRole::Editor, $roleMiddleware);
    }

    public function testShowShouldReturnCorrectResponseWithStatusCode200() {
        $this->mock(BlogRepository::class, function ($blogRepository) {
            $blogRepository->allows('getSpecificBlog')->andReturn(new Blog());
        });
        $response = $this->get('/blogs/1');
        $response->assertOk();
    }

    public function testShowShouldReturnView() {
        $this->mock(BlogRepository::class, function ($blogRepository) {
            $blogRepository->allows('getSpecificBlog')->andReturn(new Blog());
        });
        $response = $this->get('/blogs/1');
        $response->assertViewIs('blog.show');
    }

    public function testShowShouldReturnViewThatHasProperBinding() {
        $this->mock(BlogRepository::class, function ($blogRepository) {
            $blogRepository->allows('getSpecificBlog')->andReturn(new Blog());
        });
        $response = $this->get('/blogs/1');
        $response->assertViewHas('blogs');
    }

    public function testCreateShouldRespondWithStatusCode200() {
        $response = $this->get('/blogs/create');
        $response->assertOk();
    }

    public function testCreateShouldReturnTheProperView() {
        $response = $this->get('/blogs/create');
        $response->assertViewIs('blog.create');
    }

    /**
     * Helper method that returns and associative array containing blog fields
     */
    private function getStorePostData(): array {
        return [
            'title' => 'test title',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer cursus massa dolor, in
                          consectetur dui dignissim vitae. Nulla id magna nunc. Etiam facilisis id ipsum sed malesuada.
                          Morbi non suscipit orci. Aliquam in nunc sit amet nulla venenatis pretium a lobortis nulla.
                          Phasellus vel odio at dui consequat dignissim. Pellentesque nunc mi, molestie et dui ac,
                          ullamcorper egestas risus. Sed pellentesque aliquam nunc, at commodo quam luctus sit amet.
                          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam eu ipsum at arcu consequat
                          consectetur at ut ipsum. Ut aliquet ultrices ipsum id consectetur. Aliquam tincidunt lorem in
                          dapibus sagittis. Cras mollis orci sit amet magna pharetra venenatis. Nam et ornare dui.'
        ];
    }

    /**
     * Uses laravel built in mock function to bind a mocked BlogRepository into the service container
     */
    private function bindMockedInsertBlogMethodOnBlogRepository(): void {
        $this->mock(BlogRepository::class, function ($blogRepository) {
            $blogRepository->allows('insertBlog')->andReturn(1);
        });
    }

    // todo solve problem with blog author(user) is not an object
    /*public function testStoreShouldRedirectToProperUrl() {
        $this->bindMockedInsertBlogMethodOnBlogRepository();
        $this->mock(UserRepository::class, function ($userRepository) {
            $userRepository->allows('getAll')->andReturn(new Collection());
        });
        Notification::fake();
        $user = new User();
        $user->name = "test name";
        Auth::shouldReceive('user')->andReturn($user);
        $response = $this->post('/blogs', $this->getStorePostData());
        $response->assertRedirect('/blogs/1');
    }*/

    // the 3 tests below are disabled because I couldn't find a way to disable policy authorization.
    /*    public function testEditShouldRespondWithStatusCode200() {
        $response = $this->get('/blogs/1/edit');
        $response->assertOk();
    }

    public function testEditShouldRespondWithProperView() {
        $response = $this->get('/blogs/1/edit');
        $response->assertViewIs('blog.edit');
    }

    public function testEditShouldReturnViewWithABlog() {
        $response = $this->get('/blogs/1/edit');
        $response->assertViewHas('blog');
    }*/

    protected function tearDown(): void {
        parent::tearDown();
        \Mockery::close();
    }

}
