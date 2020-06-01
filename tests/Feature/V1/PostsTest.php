<?php

namespace Tests\Feature\V1;

use Tests\TestCase;

class PostsTest extends TestCase
{
    /**
     * @return void
     */
    public function testUserPostsEndpointReturnListOfPosts()
    {
        $response = $this->get('api/v1/users/1/posts');

        $response->assertStatus(200);

        $data = $response->json();
        $this->assertCount(10, $data);

        $this->assertEquals(1, $data[0]['id']);
        $this->assertEquals("sunt aut facere repellat provident occaecati excepturi optio reprehenderit",
            $data[0]['title']);

        foreach ($data as $post) {
            $this->assertEquals(1, $post['userId']);
        }
    }
}
