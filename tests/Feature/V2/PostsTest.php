<?php

namespace Tests\Feature\V2;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testUsersEndpointReturnListOfUsers()
    {
        $this->assertCount(0, Post::all());

        factory(User::class)->create(['external_id' => 1]);

        $response = $this->get('api/v2/users/1/posts');

        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertCount(10, $data);

        $this->assertEquals("sunt aut facere repellat provident occaecati excepturi optio reprehenderit",
            $data[0]['title']);

        $user = User::where('external_id', 1)->first();

        foreach ($data as $post) {
            $this->assertEquals($user->id, $post['user_id']);
        }

        // Check that posts are stored in db
        $this->assertCount(10, Post::all());

        // Check that on second call doesn't create again the posts
        $this->get('api/v2/users/1/posts');
        $this->assertCount(10, Post::all());
    }


    /**
     * @return void
     */
    public function testUserPostsEndpointReturnListOfPostsFilteredByTitle()
    {
        factory(User::class)->create(['external_id' => 1]);

        $response = $this->get('api/v2/users/1/posts?title=titleThatDoesntExist');

        $response->assertStatus(200);

        $data = $response->json('data');

        $this->assertCount(0, $data);


        $response = $this->get('api/v2/users/1/posts?title=facere');

        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertCount(1, $data);

        $post = Post::where('title', 'sunt aut facere repellat provident occaecati excepturi optio reprehenderit')->first();
        $this->assertEquals("sunt aut facere repellat provident occaecati excepturi optio reprehenderit",
            $data[0]['title']);

        $this->assertEquals($post->title, $data[0]['title']);
    }
}
