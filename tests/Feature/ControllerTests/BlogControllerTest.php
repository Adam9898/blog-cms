<?php

namespace Tests\Feature\ControllerTests;

use App\Blog;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use RoleSeeder;
use Tests\TestCase;

class BlogControllerTest extends TestCase {

    use RefreshDatabase;

    private const TABLE_NAME = 'blogs';
    private $blogArr;

    protected function setUp(): void {
        parent::setUp();
        $this->seed(RoleSeeder::class);
        $blog = factory(Blog::class)->create();
        $this->blogArr = $blog->toArray();
        $blog->user->roles()->attach([1, 2]);
        $this->actingAs($blog->user);
    }

    public function testShowShouldReturnCorrectResponseWithStatusCode200() {
        $response = $this->get('/blogs/1');
        $response->assertOk();
    }

    public function testShowShouldReturnView() {
        $response = $this->get('/blogs/1');
        $response->assertViewIs('blog.show');
    }

    public function testShowShouldReturnViewThatHasProperBinding() {
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

    public function testStoreShouldRedirectToProperUrl() {
        $newBlog = factory(Blog::class)->make();
        $postData = $newBlog->toArray();
        $response = $this->post('/blogs', $postData);
        $response->assertRedirect('/blogs/2');
    }

    public function testStoreShouldInsertPostDataToDatabase() {
        $newBlog = factory(Blog::class)->make([
            'user_id' => 1
        ]);
        $postData = $newBlog->toArray();
        $this->actingAs($newBlog->user);
        $response = $this->post('/blogs', $postData);
        $this->assertDatabaseHas(self::TABLE_NAME ,$postData);
    }

   public function testEditShouldRespondWithStatusCode200() {
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
    }

   public function testUpdateShouldRedirectToProperPage() {
        $updateBlog = factory(Blog::class)->make();
        $updatePostData = $updateBlog->toArray();
        $response = $this->put('/blogs/1', $updatePostData);
        $response->assertRedirect('/blogs/1');
   }

   public function testUpdateShouldUpdateTheCorrectDatabaseRecord() {
       $updateBlog = factory(Blog::class)->make([
           'user_id' => 1
       ]);
       $updatePostData = $updateBlog->toArray();
       $response = $this->put('/blogs/1', $updatePostData);
       $this->assertDatabaseHas(self::TABLE_NAME, $updatePostData);
   }

   private function getUpdatePostData(): array {
        return [
            'title' => 'random test title',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vel eleifend mauris, sit amet
            facilisis purus. Mauris ut accumsan orci. Ut ultrices vitae quam vitae consequat. Nam condimentum purus
            vitae lacus tristique malesuada. Suspendisse id nulla et mauris posuere pulvinar. Nam vitae ante ac magna
            euismod pellentesque. Pellentesque vel laoreet odio, quis mollis ipsum. Sed at arcu sit amet nisl congue
            lobortis. Morbi vitae mollis orci, nec semper metus. Cras non mattis sem, et elementum velit. Ut congue
            nec velit eget bibendum.'
        ];
   }

   public function testUpdateShouldUpdateDatabaseRecord() {
        $originalBlog = Blog::findOrFail(1);
        $this->put('/blogs/1', $this->getUpdatePostData());
        $this->assertDatabaseMissing(self::TABLE_NAME, $originalBlog->toArray());
   }

   /**
    * This test is here to make sure that when a user sends a different user id in the PUT request
    * it doesn't update the wrong user;
    */
   public function testUpdateShouldNotUpdateBlogWithWrongUserId() {
        //$user2 = factory(User::class)->create();
        $blog2 = factory(Blog::class)->create();
        $blog2Arr = $blog2->toArray();
        $postData = $this->getUpdatePostData();
        $postData['user_id'] = 2; // the test still acts as user with id = 1
        $response = $this->put('/blogs/1',$postData);
        $this->assertDatabaseHas(self::TABLE_NAME, $blog2Arr);
        // this should fail if blog2 gets modified in the database
   }

   public function testDeleteShouldRedirectToHomePage() {
       $response = $this->delete('/blogs/1');
       $response->assertRedirect('/');
   }

   public function testDeleteShouldSoftDeleteBlog() {
       $this->delete('/blogs/1');
       $this->assertSoftDeleted(self::TABLE_NAME, $this->blogArr);
   }

}
