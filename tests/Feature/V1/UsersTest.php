<?php

namespace Tests\Feature\V1;

use Tests\TestCase;

class UsersTest extends TestCase
{
    /**
     * @return void
     */
    public function testUsersEndpointReturnListOfUsers()
    {
        $response = $this->get('api/v1/users');
        $response->assertStatus(200);

        $data = $response->json();
        $this->assertCount(10, $data);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUsersSpecificEndpointReturnSingleUser()
    {
        $response = $this->get('api/v1/users/1');
        $response->assertStatus(200);

        $data = $response->json();

        $this->assertEquals(1, $data['id']);
        $this->assertEquals("Leanne Graham", $data['name']);
        $this->assertEquals("Sincere@april.biz", $data['email']);
    }
}
