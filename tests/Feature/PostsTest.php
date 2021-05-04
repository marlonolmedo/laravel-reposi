<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\BlogPost;
use App\Models\Comment;

class PostsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testNoBlogPostWhenNothingInDatabase()
    {
        $response = $this->get('/posts');

        $response->assertSeeText('NO POST FOUND!');
    }

    public function testSee1BlogPostWhenThereIs1WithNoComments()
    {
        //arrange
        $post = $this->createDummyBlogpost();

        //act
        $response = $this->get('/posts');

        //assert
        $response->assertSeeText('new title');
        $response->assertSeeText('no coments yet!');

        $this->assertDatabaseHas('blog_posts',[
            'title' => 'new title'
        ]);
    }

    public function testStoreValid(){

        $params = [
            'title' => 'valid title',
            'content' => 'at least 10 characters'
        ];

        $this->actingAs($this->user())->post('/posts',$params)
        ->assertStatus(302)
        ->assertSessionHas('status');

        $this->assertEquals(session('status'),'the blog post was created!');
        
    }

    public function testStoreFail(){
        $params = [
            'title' => 'x',
            'content' => 'x'
        ];

        $this->actingAs($this->user())->post('/posts',$params)
        ->assertStatus(302)
        ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();
        //dd($messages->getMessages());
        $this->assertEquals($messages['title'][0],'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0],'The content must be at least 10 characters.');
        
    }

    public function testUpdateValid(){

        //arrange
        $post = $this->createDummyBlogpost();

        $this->assertDatabaseHas('blog_posts',[
            "id" => 1,
            "title" => "new title",
            "content" => "content to content post",
            // "created_at" => date("Y-m-d HH:mm:ss"),
            // "updated_at" => date("Y-m-d HH:mm:ss")
        ]);

        $params = [
            'title' => 'a new name',
            'content' => 'content new for testing examples'
        ];

        $this->actingAs($this->user())->put("/posts/{$post->id}",$params)
        ->assertStatus(302)
        ->assertSessionHas('status');

        $this->assertEquals(session('status'),'Blogpost was update');

        $this->assertDatabaseMissing('blog_posts',[
            "id" => 1,
            "title" => "new title",
            "content" => "content to content post"
        ]);

        // $this->assertDatabaseHas('blog_posts',[
        //     "id" => 1,
        //     "title" => "a new name",
        //     "content" => "content new for testing examples",
        //     "created_at" => date("Y-m-d HHHH:mmmm:ssss"),
        //     "updated_at" => date("Y-m-d HHHH:mmmm:ssss")
        // ]);
        
    }

    public function testDeleteValid(){

        //arrange
        $post = $this->createDummyBlogpost();

        $this->assertDatabaseHas('blog_posts',[
            "id" => 1,
            "title" => "new title",
            "content" => "content to content post",
        ]);

        $this->actingAs($this->user())->delete("/posts/{$post->id}")
        ->assertStatus(302)
        ->assertSessionHas('status');

        $this->assertEquals(session('status'),'Bloc post was deleted!');

        $this->assertDatabaseMissing('blog_posts',[
            "id" => 1,
            "title" => "new title",
            "content" => "content to content post"
        ]);
        
    }

    private function createDummyBlogpost(): BlogPost{

        $post = new BlogPost();
        $post->title = "new title";
        $post->content = "content to content post";
        $post->save();

        return $post;
    }

    public function testSeeBlogPostWithComments(){
        $post = $this->createDummyBlogpost();
        Comment::factory(4)->create([
            'blog_post_id' => $post->id
        ]);
        
        $response = $this->get('/posts');

        $response->assertSeeText('4 Comments');
    }
}
