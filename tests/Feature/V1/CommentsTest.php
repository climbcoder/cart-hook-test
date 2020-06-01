<?php

namespace Tests\Feature\V1;

use Tests\TestCase;

class PostssTest extends TestCase
{
    /**
     * @return void
     */
    public function testPostCommentsEndpointReturnListOfComments()
    {
        $response = $this->get('api/v1/posts/1/comments');

        $response->assertStatus(200);

        $data = $response->json();
        $this->assertCount(5, $data);

        $this->assertEquals(1, $data[0]['id']);
        $this->assertEquals("id labore ex et quam laborum", $data[0]['name']);
        $this->assertEquals("Eliseo@gardner.biz", $data[0]['email']);

        foreach ($data as $comment) {
            $this->assertEquals(1, $comment['postId']);
        }
    }
}
